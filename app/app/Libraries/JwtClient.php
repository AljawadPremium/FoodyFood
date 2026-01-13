<?php

namespace App\Libraries;

use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class JwtClient
{
    // Security key to encode / decode JWT
    private $mSecretKey;

    // Claim info
    private $mIssuer;
    private $mExpiry;
    private $key;
    
    public function __construct()
    {
        $this->key = 'secret';
        $this->mSecretKey ='example_key';
        $this->mIssuer = 'CI Bootstrap 3';
        $this->mExpiry = NULL;
    }

    // Encode to JWT
    // Append custom data via $data array, e.g. array('user_id' => 1)
    public function encode($data = array())
    {
        helper('text');
        // References:
        //  - http://self-issued.info/docs/draft-ietf-oauth-json-web-token.html
        //  - http://websec.io/2014/08/04/Securing-Requests-with-JWT.html
        // 
        // Registered Claim Names (all optional):
        //  - iss = Issuer
        //  - sub = Subject
        //  - aud = Audience
        //  - exp = Expiration Time
        //  - nbf = Not Before
        //  - iat = Issued At
        //  - jti = JWT ID
        $curr_time = time();
        $token = array(
            "iss" => $this->mIssuer,
            "iat" => $curr_time,
            "jti" => random_string('unique')
        );

        // add expiry when necessary
        if ( !empty($this->mExpiry) )
            $token['exp'] = $curr_time + $this->mExpiry;

        // append data to store with token
        if ( !empty($data) )
            $token = array_merge($token, $data);        
        // encode and return string   
        
        return JWT::encode($token, $this->mSecretKey, 'HS256');
    }

    // Decode token
    // Return NULL when exception is caught
    public function decode($jwt)
    {  
        try { 
            $decoded = JWT::decode($jwt, new Key($this->mSecretKey, 'HS256'));            
            return (array)$decoded; 
        } catch (\Firebase\JWT\SignatureInvalidException $e) {
            echo  'invalid JWT'; die;
            return NULL;
        } catch (\Firebase\JWT\ExpiredException $e) {
            echo 'JWT is expired'; die;
            return NULL;
        } catch (\Firebase\JWT\BeforeValidException $e) {            
            echo 'JWT is not valid yet'; die;
            return NULL;
        } catch (Exception $e) {
            echo 'other exceptions'; die;            
            return NULL;
        }
    }

    public function test_jwt()
    {

        $key = 'example_key';
        $payload = [
            'iss' => 'http://example.org',
            'aud' => 'http://example.com',
            'iat' => 1356999524,
            'nbf' => 1357000000
        ];

        /**
         * IMPORTANT:
         * You must specify supported algorithms for your application. See
         * https://tools.ietf.org/html/draft-ietf-jose-json-web-algorithms-40
         * for a list of spec-compliant algorithms.
         */
        $jwt = JWT::encode($payload, $key, 'HS256');

    }

    public function generateToken_1($data)
    {
        // $token = array(
        //     "iss" => "http://example.org",
        //     "aud" => "http://example.com",
        //     "iat" => 1356999524,
        //     "nbf" => 1357000000,
        //     "data" => $data
        // );

        $curr_time = time();

        $token = array(
            "iss" => $this->mIssuer,
            "iat" => $curr_time,
            "jti" =>  random_int(100000, 999999),
            "data" => $data
        );
        return $this->encode_1($token);
    }

    public function generateStaticToken($data)
    {
        $curr_time = time();

        $token = array(
            "iss" => $this->mIssuer,
            "iat" => $curr_time,
            "jti" =>  random_int(100000, 999999),
            "api_key" => $data
        );
        return $this->encode_1($token);
    }

    public function decodeToken_1($token)
    {
        return $this->decode_1($token);
    }

    public function encode_1($data)
    {
        return JWT::encode($data, $this->mSecretKey, 'HS256');
    }

    public function decode_1($data)
    {
        // return JWT::decode($data, $this->mIssuer, 'HS256');
        return $data = JWT::decode($data, new Key($this->mIssuer, 'HS256')) ;
    }
}