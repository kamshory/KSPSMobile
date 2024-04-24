<?php
class AES {
  
    const CIPHER = 'AES-128-CBC';
    const INIT_VECTOR_LENGTH = 16;
    /**
     * Encoded/Decoded data
     *
     * @var null|string
     */
    protected $data;
    /**
     * Initialization vector value
     *
     * @var string
     */
    protected $initVector;
    /**
     * Error message if operation failed
     *
     * @var null|string
     */
    protected $errorMessage;
    /**
     * AesCipher constructor.
     *
     * @param string $initVector        Initialization vector value
     * @param string|null $data         Encoded/Decoded data
     * @param string|null $errorMessage Error message if operation failed
     */
    public function __construct($initVector, $data = null, $errorMessage = null)
    {
        $this->initVector = $initVector;
        $this->data = $data;
        $this->errorMessage = $errorMessage;
    }
    /**
     * Encrypt input text by AES-128-CBC algorithm
     *
     * @param string $secretKey 16/24/32 -characters secret password
     * @param string $plainText Text for encryption
     *
     * @return self Self object instance with data or error message
     */
    public static function encrypt($secretKey, $plainText)
    {
        try {
            // Check secret length
            if (!static::isKeyLengthValid($secretKey)) {
                throw new \InvalidArgumentException("Secret key's length must be 128, 192 or 256 bits");
            }
            // Get random initialization vector
            $initVector = bin2hex(openssl_random_pseudo_bytes(static::INIT_VECTOR_LENGTH / 2));
            // Encrypt input text
            $raw = openssl_encrypt(
                $plainText,
                static::CIPHER,
                $secretKey,
                OPENSSL_RAW_DATA,
                $initVector
            );
            // Return base64-encoded string: initVector + encrypted result
            $result = base64_encode($initVector . $raw);
            if ($result === false) 
			{
                // Operation failed
                return new AES($initVector, null, openssl_error_string());
            }
            // Return successful encoded object
            return new AES($initVector, $result);
        } catch (Exception $e) {
            // Operation failed
            return new AES(isset($initVector), null, $e->getMessage());
        }
    }
    /**
     * Decrypt encoded text by AES-128-CBC algorithm
     *
     * @param string $secretKey  16/24/32 -characters secret password
     * @param string $cipherText Encrypted text
     *
     * @return self Self object instance with data or error message
     */
    public static function decrypt($secretKey, $cipherText)
    {
        try {
            // Check secret length
            if (!static::isKeyLengthValid($secretKey)) {
                throw new \InvalidArgumentException("Secret key's length must be 128, 192 or 256 bits");
            }
            // Get raw encoded data
            $encoded = base64_decode($cipherText);
            // Slice initialization vector
            $initVector = substr($encoded, 0, static::INIT_VECTOR_LENGTH);
            // Slice encoded data
            $data = substr($encoded, static::INIT_VECTOR_LENGTH);
            // Trying to get decrypted text
            $decoded = openssl_decrypt(
                $data,
                static::CIPHER,
                $secretKey,
                OPENSSL_RAW_DATA,
                $initVector
            );
            if ($decoded === false) 
			{
                // Operation failed
                return new AES(isset($initVector), null, openssl_error_string());
            }
            // Return successful decoded object
            return new AES($initVector, $decoded);
        } 
		catch (Exception $e) 
		{
            // Operation failed
            return new AES(isset($initVector), null, $e->getMessage());
        }
    }
    /**
     * Check that secret password length is valid
     *
     * @param string $secretKey 16/24/32 -characters secret password
     *
     * @return bool
     */
    public static function isKeyLengthValid($secretKey)
    {
        $length = strlen($secretKey);
        return $length == 16 || $length == 24 || $length == 32;
    }
    /**
     * Get encoded/decoded data
     *
     * @return string|null
     */
    public function getData()
    {
        return $this->data;
    }
    /**
     * Get initialization vector value
     *
     * @return string|null
     */
    public function getInitVector()
    {
        return $this->initVector;
    }
    /**
     * Get error message
     *
     * @return string|null
     */
    public function getErrorMessage()
    {
        return $this->errorMessage;
    }
    /**
     * Check that operation failed
     *
     * @return bool
     */
    public function hasError()
    {
        return $this->errorMessage !== null;
    }
    /**
     * To string return resulting data
     *
     * @return null|string
     */
    public function __toString()
    {
        return $this->getData();
    }
}
function encryptPIN($inputKey, $inputText)
{
	$blockSize = 128;
	$aes = new AES($inputText, $inputKey, $blockSize);
	$data = array(
		mt_rand(1, 2000000000),
		mt_rand(1, 2000000000),
		$inputText,
		mt_rand(1, 2000000000),
		mt_rand(1, 2000000000),
	);
	$out = "";
	foreach($data as $k=>$val)
	{
		$str = "".$val;
		$out .= sprintf("%03d%s", strlen($str), $str);
	}
	return $aes->encrypt($inputKey, $out);
}
function decryptPIN($inputKey, $inputText)
{
	$blockSize = 128;
	$aes = new AES($inputText, $inputKey, $blockSize);
	$plaintext = $mod = $aes->decrypt($inputKey, $inputText);
	$i = 0;
	if(strlen($mod) > 3)
	{
		do{
			$len = substr($mod, 0, 3);
			$len = ltrim($len, '0');
			if($len == '')
			{
				$len = '0';
			}
			$length = $len * 1;
			$mod = substr($mod, 3);
			$list[$i] = substr($mod, 0, $length);
			$mod = substr($mod, $length);
			$i++;
		} while(strlen($mod) > 2);
	}
	$out = '';
	if(isset($list[2]))
	{
		$out = $list[2];
	}
	return $out;
}
function encrypt($inputKey, $inputText)
{
	$blockSize = 128;
	$aes = new AES($inputText, $inputKey, $blockSize);
	return $aes->encrypt($inputKey, $inputText);
}
function decrypt($inputKey, $inputText)
{
	$blockSize = 128;
	$aes = new AES($inputText, $inputKey, $blockSize);
	$plaintext = $aes->decrypt($inputKey, $inputText);
	return $plaintext;
}

?>