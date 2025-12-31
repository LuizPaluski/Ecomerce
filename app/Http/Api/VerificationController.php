<?php 

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\SendVerificationCode;
use Carbon\Carbon;

class VerificationController extends Controller
{

    public function sendCode(Request $request)
    {
        $user = auth()->user(); 
        
        $code = rand(100000, 999999);
        
        $user->verification_code = $code;
        $user->verification_code_expires_at = Carbon::now()->addMinutes(10);
        $user->save();

        Mail::to($user->email)->send(new SendVerificationCode($code));

        return response()->json(['message' => 'Código enviado com sucesso!']);
    }

 
    public function verifyCode(Request $request)
    {
        $request->validate([
            'code' => 'required|integer'
        ]);

        $user = auth()->user();

        if ($user->verification_code === $request->code && Carbon::now()->lessThanOrEqualTo($user->verification_code_expires_at)) {
            
            $user->email_verified_at = Carbon::now();

            $user->verification_code = null;
            $user->verification_code_expires_at = null;
            $user->save();

            return response()->json(['message' => 'E-mail verificado com sucesso!']);
        }

        return response()->json(['error' => 'Código inválido ou expirado.'], 400);
    }
}