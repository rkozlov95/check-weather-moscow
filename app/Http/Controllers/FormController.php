<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;

class FormController extends Controller
{
    public function show()
    {
        return view('form');
    }

    public function getWeather(Request $request)
    {
        $app_id = config("here.app_id");
        $app_code = config("here.app_code");
        $url = "https://weather.api.here.com/weather/1.0/report.json?product=observation&name=Moscow&language=ru&app_id=${app_id}&app_code=${app_code}";
        $client = new \GuzzleHttp\Client();
        $result = $client->get($url);
        if ($result->getStatusCode() == 200) {
            $body = $result->getBody();
            $obj = json_decode($body);
            $currentForecast = $obj->observations->location[0]->observation[0];
        }

        $name = $request->get('name');
        $email = $request->get('email');

        $temperature = $currentForecast->temperature;

        $currentTime = Carbon::now('Europe/Moscow')->format('H:i');

        $message = "В {$currentTime} в Москве погода {$temperature} градусов.";

        $isSendMessage = false;

        if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
            Mail::raw($message, function ($msg) use ($email) {
                $msg->to($email)->subject("Прогноз погоды в Москве");
            });
            $isSendMessage = true;
        }

        $alert = ($isSendMessage) ?
            '<div class="alert alert-success" role="alert">
                Успешно отправлено!
             </div>' :
            '<div class="alert alert-danger" role="alert">
                Сообщение не отправлено!
             </div>';

        $response = [
            'alert' => $alert,
            'message' => $message,
        ];

        return response()->json($response);
    }
}
