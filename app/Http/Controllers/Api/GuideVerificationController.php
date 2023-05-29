<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\GuideVerificationRequest;
use App\Http\Resources\GuideVerificationResource;
use App\Models\GuideVerification;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;


class GuideVerificationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return GuideVerificationResource::collection(GuideVerification::where('is_verified', 0)->get());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(GuideVerificationRequest $request) // тут
    {
        try {
            $photo_certificate = Str::random(32).".".$request->photo_certificate->getClientOriginalExtension();
            $photo_passport = Str::random(32).".".$request->photo_passport->getClientOriginalExtension();
            $photo_passport_with_selfie = Str::random(32).".".$request->photo_passport_with_selfie->getClientOriginalExtension();
            
            #create 
            $data = GuideVerification::create([
                'user_id' => $request->user_id,
                'is_verified' => $request->is_verified,
                'photo_certificate' => $photo_certificate,
                'photo_passport' => $photo_passport,
                'photo_passport_with_selfie' => $photo_passport_with_selfie
            ]);

            #сохранение изображения
            Storage::disk('public')->put($photo_certificate, file_get_contents($request->photo_certificate));
            Storage::disk('public')->put($photo_passport, file_get_contents($request->photo_passport));
            Storage::disk('public')->put($photo_passport_with_selfie, file_get_contents($request->photo_passport_with_selfie));

            return response()->json([
                'message' => 'Created',
                'data' => new GuideVerificationResource($data)
            ], 200);


        } catch (\Exception $e) {
            return $e;
            return response()->json([
                'message' => 'Something went wrong'
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(GuideVerification $guideVerification)
    {
        return new GuideVerificationResource($guideVerification);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(GuideVerificationRequest $request, $id)
    {
        if(!$request->message_about_not_verified){
            $data = GuideVerification::find($id);
            $data->update([
                'is_verified' => $request->is_verified,
            ]);
            return new GuideVerificationResource($data);
        }else {
            $data = GuideVerification::find($id);
            $data->update([
                'is_verified' => $request->is_verified,
                'message_about_not_verified' => $request->message_about_not_verified
            ]);
            return new GuideVerificationResource($data);
        }
        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(GuideVerification $guideVerification)
    {
        $guideVerification->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function getIsVerified($user_id)
    {
        $isVerified = User::join('guide_verification', 'users.id', '=', 'guide_verification.user_id')
            ->where('users.id', $user_id)
            ->value('guide_verification.is_verified');

        return $isVerified;
    }

    public function getIsSubmitted($user_id)
    { 
        $verification = GuideVerification::where('user_id', $user_id)
        ->where('is_verified', false)
        ->exists();

        return $verification;
    }

    public function hasMessage($user_id) 
    {
        $message = GuideVerification::where('user_id', $user_id)->get();

        return $message;
    }

    public function updateSecondAfterGettingMessage(GuideVerificationRequest $request, $id)
    {
        try {
            $photo_certificate = Str::random(32).".".$request->photo_certificate->getClientOriginalExtension();
            $photo_passport = Str::random(32).".".$request->photo_passport->getClientOriginalExtension();
            $photo_passport_with_selfie = Str::random(32).".".$request->photo_passport_with_selfie->getClientOriginalExtension();

            $data = GuideVerification::find($id);
            $data->update([
                'message_about_not_verified' => null,
                'photo_certificate' => $request->photo_certificate,
                'photo_passport' => $request->photo_passport,
                'photo_passport_with_selfie' => $request->photo_passport_with_selfie
            ]);

            #сохранение изображения
            Storage::disk('public')->put($photo_certificate, file_get_contents($request->photo_certificate));
            Storage::disk('public')->put($photo_passport, file_get_contents($request->photo_passport));
            Storage::disk('public')->put($photo_passport_with_selfie, file_get_contents($request->photo_passport_with_selfie));

            return response()->json([
                'message' => 'Created',
                'data' => new GuideVerificationResource($data)
            ], 200);
        } catch (\Exception $e) {
            return $e;
            return response()->json([
                'message' => 'Something went wrong'
            ], 500);
        }
    }
}
