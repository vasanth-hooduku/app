<?php
/**
* Class and Function List:
* Function list:
* - AWSAuth()
* - authenticate()
* Classes list:
* - CloudProvider
*/
//require_once SHARED_ADDONPATH . 'libraries/aws/aws.phar';
class CloudProvider {
    private static $aws;
    private static function AWSAuth($account) {
        $credentials = json_decode($account->credentials);
        $config['key'] = $credentials->apiKey;
        $config['secret'] = $credentials->secretKey;
        $config['region'] = 'us-east-1';
        self::$aws = Aws\Common\Aws::factory($config);
        
        $conStatus = FALSE;
        try {
            $ec2Compute = self::$aws->get('ec2');
			$images = $ec2Compute -> getIterator('DescribeImages');
			$arr = '';
			foreach ($images as $image)
			{
				$arr[] = $image;
			}
			
            $conStatus = (!empty($arr) && count($arr) > 0);
        }
        catch(Exception $ex) {
            $conStatus = FALSE;
            Log::error($ex);
            //log_message('error', 'Connection failed with API and Secret .' . $ex->getMessage());
            
        }
        return $conStatus;
    }
    
    public static function authenticate($account) {
        switch ($account->cloudProvider) {
            case 'Amazon AWS':
                return self::AWSAuth($account);
            break;
        }
    }
}
