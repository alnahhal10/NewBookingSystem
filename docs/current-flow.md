# التدفقات الحالية للنظام - NewBookingSystem

## 1) تدفق الحجز (الوضع الحالي)

### نقاط الدخول
- المسارات:
  - `GET /bookings/create` -> `BookingController@create`
  - `POST /bookings` -> `BookingController@store`
  - `GET /my-bookings` -> `BookingController@index`
- الملف: `routes/web.php`
- الحماية: مجموعة `auth` (يتطلب تسجيل دخول).

### المدخلات والتحقق
- في شاشة إنشاء الحجز (`create`):
  - يقرأ `room_id`, `check_in`, `check_out` من query string.
  - إذا لا يوجد غرفة أو تواريخ، يتم redirect مع رسالة خطأ.
- في حفظ الحجز (`store`):
  - `room_id`: مطلوب وموجود في `rooms`.
  - `check_in`: تاريخ مطلوب >= اليوم.
  - `check_out`: تاريخ مطلوب > `check_in`.
- ملاحظة: التحقق هنا inline داخل الكنترولر وليس Form Request.

### منطق العمل
1. جلب الغرفة مع `roomType`.
2. فحص التوفر باستخدام `Room::isAvailable(check_in, check_out)`.
3. حساب عدد الليالي والسعر الإجمالي.
4. إنشاء سجل في `bookings` بحالة:
   - `status = confirmed`
   - `payment_status = pending`
5. إعادة التوجيه إلى مسار الدفع `bookings.pay`.

### التغييرات على قاعدة البيانات
- الجدول المتأثر: `bookings`.
- الحقول المتغيرة: `user_id`, `room_id`, `check_in`, `check_out`, `total_price`, `status`, `payment_status`.

### المخرجات
- نجاح: redirect إلى `/bookings/{booking}/pay`.
- فشل التوفر: الرجوع للصفحة السابقة برسالة خطأ.
- فشل إدخال معطيات create: redirect إلى الصفحة المناسبة برسالة خطأ.

### ملاحظات ومخاطر
- حالة الحجز تبدأ `confirmed` قبل اكتمال الدفع (عدم اتساق state).
- لا يوجد Form Request مخصص للحجز.
- لا يوجد توثيق صريح لانتقالات الحالة (state machine).

---

## 2) تدفق الدفع (الوضع الحالي)

### نقاط الدخول
- المسارات:
  - `GET|POST /bookings/{booking}/pay` -> `PaymentController@createSession`
  - `GET /payments/success/{booking}` -> `PaymentController@success`
  - `GET /payments/cancel/{booking}` -> `PaymentController@cancel`
  - `POST /webhook/stripe` -> `PaymentController@webhook`
- الملف: `routes/web.php`

### إنشاء جلسة الدفع (Checkout Session)
- يتحقق أولًا إن كان `payment_status` مدفوعًا بالفعل.
- يبني `line_items` من بيانات الحجز والغرفة.
- يحفظ `stripe_session_id` في سجل الحجز.
- يعيد توجيه المستخدم إلى Stripe Checkout URL.

### معالجة الـ Webhook
- يقرأ `payload` و `Stripe-Signature`.
- يتحقق من صحة الحدث عبر `Webhook::constructEvent`.
- عند `checkout.session.completed`:
  - يبحث عن الحجز عبر `stripe_session_id`.
  - يحدّث:
    - `payment_status = paid`
    - `status = confirmed`
- يعيد JSON `received: true`.

### انتقال الحالات (State Transition)
- قبل الدفع: `payment_status = pending`.
- بعد نجاح webhook: `payment_status = paid` و `status = confirmed`.
- عند الإلغاء: لا يوجد تعديل حالة في قاعدة البيانات (رسالة فقط للمستخدم).

### ملاحظات ومخاطر
- لا يوجد فحص ملكية الحجز داخل `PaymentController` (IDOR محتمل).
- Route الـ webhook موجود داخل `web.php` وقد يتأثر بسياق middleware/CSRF.
- استخدام `Log::...` داخل `PaymentController` بدون استيراد `Log` facade.
- لا يوجد idempotency tracking صريح لأحداث Stripe المكررة.

---

## 3) تدفق API (الوضع الحالي)

### مصادقة المستخدم (Auth API)
- المسارات العامة:
  - `POST /api/register` -> `Api\AuthController@register`
  - `POST /api/login` -> `Api\AuthController@login`
- المسارات المحمية (`auth:sanctum`):
  - `POST /api/logout`

### فنادق API
- ضمن `auth:sanctum`:
  - `GET /api/hotels`
  - `GET /api/hotels/{id}`
  - `POST /api/hotels`
  - `POST /api/hotels/{id}` (للـ update)
  - `DELETE /api/hotels/{id}`
- الكنترولر: `app/Http/Controllers/Api/HotelController.php`.

### تنسيق الاستجابات
- يستخدم `HotelResource` + `ApiResponseTrait` في `Api\HotelController`.
- `Api\AuthController` يعيد JSON مباشر بصيغة مختلفة.
- النتيجة: عدم اتساق واضح في شكل الاستجابات بين endpoints.

### ملاحظات ومخاطر
- route التحديث يستخدم `POST` بدل `PUT/PATCH` (مخالفة REST conventions).
- في `Api\HotelController@update`: يتم استدعاء `$hotel->update()` قبل التحقق أن الفندق موجود.
- imports في `routes/api.php` تحتوي مراجع قد تكون غير مستخدمة/غير موجودة (`OrderController`, `Api\Controller`).

---

## 4) قائمة أولويات الإصلاح (Fix-First Backlog)

1. **[P1]** فرض Authorization على دفع الحجز (ملكية الحجز + Policy).
2. **[P1]** إصلاح تدفق حالات الحجز/الدفع ليبدأ `pending_payment` بدل `confirmed`.
3. **[P1]** إصلاح أخطاء API الحرجة (`HotelController@update` وترتيب فحص null قبل update).
4. **[P2]** توحيد Validation باستخدام Form Requests في الحجز والدفع وAPI.
5. **[P2]** توحيد API response format بين `AuthController` و `HotelController`.
6. **[P2]** نقل webhook route بشكل آمن مع ضمان عدم تعارض CSRF/localization.
7. **[P3]** إضافة idempotency layer لأحداث Stripe + logging منظم.

---

## 5) نظرة على تغطية الاختبارات

### الموجود حاليًا
- توجد اختبارات أساسية (خصوصًا auth/profile).

### الناقص عالي القيمة
- اختبار إنشاء حجز ناجح/فاشل حسب التوفر.
- اختبار محاولة دفع حجز لا يخص المستخدم (Authorization).
- اختبار webhook:
  - توقيع صحيح وتحديث الحالة.
  - توقيع غير صالح.
  - تكرار نفس الحدث (idempotency).
- اختبار API للفنادق (CRUD + أخطاء + auth:sanctum).




نعم اكتب

ممتاز، هذا Checklist يومي قصير للخطوة الثانية foundation-hardening على مشروعك:

Week Plan (5 أيام)
اليوم 1 — توحيد Validation للحجز

 إنشاء StoreBookingRequest في app/Http/Requests/StoreBookingRequest.php

 نقل قواعد التحقق من BookingController@store إلى الـRequest

 استبدال Request $request بـ StoreBookingRequest $request

 التأكد أن رسائل الخطأ ما زالت واضحة للمستخدم
تعلم Senior هنا: فصل concerns (Controller orchestration فقط).

اليوم 2 — إصلاح API update safety

 إنشاء UpdateHotelApiRequest (أو اسم مناسب) في app/Http/Requests

 تعديل Api\HotelController@update ليتحقق من وجود الفندق قبل update()

 توحيد response codes:
404 عند عدم وجود الفندق
422 عند validation errors
200 عند نجاح التحديث

 مراجعة routes/api.php لمسار التحديث (POST حاليًا) ووضع ملاحظة تحويله لاحقًا إلى PUT/PATCH
تعلم Senior هنا: Defensive coding + REST correctness.

اليوم 3 — خط أساس للصلاحيات في الدفع

 إضافة فحص ملكية الحجز داخل:
PaymentController@createSession
PaymentController@success
PaymentController@cancel

 منع أي مستخدم من الوصول لحجز لا يخصه

 إرجاع redirect/response مناسبة عند الرفض
تعلم Senior هنا: route-model binding لا يعني authorization.

اليوم 4 — اختبارات Feature للحجز

 إنشاء ملف اختبار للحجوزات في tests/Feature (مثلاً BookingFlowTest.php)

 اختبار: إنشاء حجز ناجح عند توفر الغرفة

 اختبار: رفض الحجز عند عدم توفر الغرفة

 اختبار: check_out قبل check_in يفشل validation

 اختبار: المستخدم غير المسجل لا يستطيع إنشاء حجز
تعلم Senior هنا: اختبار السلوك business-first.

اليوم 5 — اختبارات الدفع + تثبيت الجودة

 إنشاء/توسيع اختبار الدفع في tests/Feature (مثلاً PaymentFlowTest.php)

 اختبار: منع دفع حجز لا يخص المستخدم

 اختبار webhook event صالح يحدّث payment_status إلى paid

 اختبار webhook غير صالح يعيد 400

 تشغيل الاختبارات ومعالجة أي كسر
تعلم Senior هنا: reliability mindset (failure scenarios قبل happy path).

Definition of Done للخطوة الثانية

 BookingController بدون validation inline للحفظ.

 Api\HotelController@update آمن من null/update crash.

 نقاط الدفع محمية بملكية الحجز.

 مجموعة اختبارات Feature تغطي أهم سيناريوهات الحجز والدفع.

 المشروع مستقر بعد التعديلات (اختبارات تمر).
ترتيب الأولوية إذا الوقت ضيق
Authorization في الدفع
إصلاح Api\HotelController@update
StoreBookingRequest
اختبارات الحجز
اختبارات webhook
إذا تريد، الخطوة التالية أحول هذا إلى نسخة تنفيذ PR-by-PR (كل يوم = PR صغير بعنوان واضح ورسالة commit مقترحة).