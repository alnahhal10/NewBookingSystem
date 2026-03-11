<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreHotelRequest;
use App\Http\Resources\HotelResource;
use App\Models\Hotel;
use App\Models\User;
use Illuminate\Http\Request;
use Validator;

class HotelController extends Controller
{
    use \App\ApiResponseTrait;
    // API endpoint to retrieve all hotels
    public function index(Request $request)
    {
       
        $hotels = HotelResource::collection(Hotel::all());
        
       return $this->apiResponse($hotels, 'Hotels retrieved successfully', 200);
    }

    public function show($id)
    {
        $hotel = Hotel::find($id);

        if($hotel) {
            return $this->apiResponse(new HotelResource($hotel), 'Hotel details retrieved successfully', 200);
        }
            return $this->apiResponse(null, 'An error occurred while retrieving hotel details', 500);
        
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
    'name'         => 'required|string|max:255',
    'city'         => 'required|string|max:255',
    'state'        => 'required|string|max:255',
    'description'  => 'nullable|string',
    'address'      => 'required|string|max:255',
    'phone_number' => 'required|string|max:20',
    'email'        => 'required|email|max:255',
    'country'      => 'required|string|max:255',
]);

if ($validator->fails()) {
    return $this->apiResponse(null, 'Validation errors', 422);
}

$hotel = Hotel::create($validator->validated());
        
        

        if($hotel) {
            return $this->apiResponse(new HotelResource($hotel), 'Hotel created successfully', 201);
        }
            return $this->apiResponse(null, 'An error occurred while creating the hotel', 400);
        
    }



    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name'         => 'sometimes|required|string|max:255',
            'city'         => 'sometimes|required|string|max:255',
            'state'        => 'sometimes|required|string|max:255',
            'description'  => 'nullable|string',
            'address'      => 'sometimes|required|string|max:255',
            'phone_number' => 'sometimes|required|string|max:20',
            'email'        => 'sometimes|required|email|max:255',
            'country'      => 'sometimes|required|string|max:255',
        ]);

        
        if ($validator->fails()) {
            return $this->apiResponse(null, 'Validation errors', 422);
        }

        $hotel = Hotel::find($id);

        $hotel->update($validator->validated());


        if(!$hotel) {
            return $this->apiResponse(null, 'Hotel not found', 404);
        }

        


        return $this->apiResponse(new HotelResource($hotel), 'Hotel updated successfully', 200);
    }

    public function destroy($id)
    {
        $hotel = Hotel::find($id);

        if(!$hotel) {
            return $this->apiResponse(null, 'Hotel not found', 404);
        }

        $hotel->delete();

        return $this->apiResponse(null, 'Hotel deleted successfully', 200);
    }
}


