<?php

namespace Esyede\TapTalk;

class SendTalk
{
    /**
     * SendTalk api key.
     *
     * @var string
     */
    private $apiKey;

    /**
     * API endpoint.
     *
     * @var string
     */
    private $endpoint;

    /**
     * Constructor.
     *
     * @param string $apiKey
     */
    public function __construct($apiKey)
    {
        $this->apiKey = $apiKey;
        $this->endpoint = 'https://sendtalk-api.taptalk.io/api/v1/message/send_whatsapp';
    }

    /**
     * Send a plain text message.
     *
     * @param sring  $receiverPhone
     * @param string $message
     *
     * @return \stdClass
     */
    public function sendText($receiverPhone, $message)
    {
        $payloads = [
            'phone' => $receiverPhone,
            'messageType' => 'text',
            'body' => $message,
        ];

        return $this->send($payloads);
    }

    /**
     * Send a text message with image.
     *
     * @param string      $receiverPhone
     * @param string      $imageUrl
     * @param string|null $imageFileName
     * @param string|null $imageCaption
     *
     * @return \stdClass
     */
    public function sendImage($receiverPhone, $imageUrl, $imageCaption = null, $imageFileName = null)
    {
        $payloads = [
            'phone' => $receiverPhone,
            'messageType' => 'image',
            'body' => $imageUrl,
        ];

        if (! is_null($imageCaption)) {
            $payloads['caption'] = $imageCaption;
        }

        if (! is_null($imageFileName)) {
            $payloads['filename'] = $imageFileName;
        }

        return $this->send($payloads);
    }

    /**
     * Send an OTP message (prioritized message).
     *
     * @param string $receiverPhone
     * @param string $message
     *
     * @return \stdClass
     */
    public function sendOTP($receiverPhone, $message)
    {
        $payloads = [
            'phone' => $receiverPhone,
            'messageType' => 'otp',
            'body' => $message,
        ];

        return $this->send($payloads);
    }

    /**
     * Kirim pesan.
     *
     * @param array $payloads
     *
     * @return \stdClass
     */
    private function send(array $payloads)
    {
        $headers = [
            'API-Key: ' . $this->apiKey,
            'Accept: application/json',
            'Content-Type: application/json',
        ];

        // Format phone number.
        $payloads['phone'] = $this->formatPhoneNumber($payloads['phone']);

        $ch = curl_init();

        curl_setopt_array($ch, [
            CURLOPT_URL => $this->endpoint,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HEADER => false,
            CURLOPT_HTTPHEADER => $headers,
            CURLOPT_FAILONERROR => false,
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => json_encode($payloads),
        ]);

        $responses = curl_exec($ch);
        $errors = curl_error($ch);

        curl_close($ch);

        $responses = json_decode($responses);

        if (JSON_ERROR_NONE !== json_last_error()) {
            $errors = 'Unable to decode json response.';
        }

        $results = [
            'method' => 'POST',
            'endpoint' => $this->endpoint,
            'requests' => compact('headers', 'payloads'),
            'responses' => $responses,
            'errors' => $errors,
        ];

        // Force to \stdClass object.
        return json_decode(json_encode($results));
    }

    /**
     * Ensure phone number begins with '62'.
     *
     * @param string $receiverPhone
     *
     * @return string
     */
    private function formatPhoneNumber($receiverPhone)
    {
        if (is_null($receiverPhone)) {
            return $receiverPhone;
        }

        $replacements = ['+62' => '62', '08' => '628'];

        foreach ($replacements as $key => $value) {
            if (0 === strpos($receiverPhone, $key)) {
                $receiverPhone = substr_replace($receiverPhone, $value, 0, strlen($key));
            }
        }

        return $receiverPhone;
    }
}