<?php

namespace KSPSMobile;

use MagicObject\Database\PicoDatabase;
use PDO;
use PDOException;

class MobileApp
{
    /**
     * Database
     *
     * @var PicoDatabase
     */
	private $database = null;
	private $app_name = "KSPS Planetbiru";
	private $app_full_name = "Mobile Koperasi PlanetCoops";
	private $app_version = "2.0.0";

    public function get_app_name()
	{
		return $this->app_name;
	}
	public function get_app_full_name()
	{
		return $this->app_full_name;
	}
	public function get_app_version()
	{
		return $this->app_version;
	}
	public function is_up_to_date($server)
	{
		$client_version = $server['HTTP_X_APPLICATION_VERSION'];
		return $this->compare_version($client_version, $this->app_version) >= 0;
	}
	private function compare_version($version1, $version2)
	{
		$a1 = explode(".", $version1, 3);
		$a2 = explode(".", $version2, 3);
		$v1 = (@$a1[0] * 1000000) + (@$a1[1] * 1000) + (@$a1[2] * 1);
		$v2 = (@$a2[0] * 1000000) + (@$a2[1] * 1000) + (@$a2[2] * 1);
		if($v1 > $v2)
		{
			return 1;
		}
		else if($v1 < $v2)
		{
			return -1;
		}
		else
		{
			return 0;
		}
	}

    /**
     * Constructor
     *
     * @param PicoDatabase $database
     */
	public function __construct($database)
	{
		$this->database = $database;
		$this->init();
	}
	public function init()
	{
		
	}
	public function execute_sql($sql)
	{
		if($this->database == null)
		{
			return null;
		}
		$db_rs = $this->database->executeQuery($sql);
	}
	public function get_num_row_from_db($sql)
	{
		if($this->database == null)
		{
			return 0;
		}
		$db_rs = $this->database->executeQuery($sql);
		return 1 * $db_rs->rowCount();
	}
	public function get_data_from_db($sql)
	{
		if($this->database == null)
		{
			return null;
		}
		$db_rs = $this->database->executeQuery($sql);;
		$db_rs->execute();
		$num = $db_rs->rowCount();
		if($num > 0)
		{
			return $db_rs->fetchAll(PDO::FETCH_ASSOC);
		}
		else
		{
			return null;
		}
	}
	public function auth($username, $password)
	{
		$sql = "select nasabah_id, nama, username, otorisasi, nik, username, telepon 
		from nasabah 
		where username = '$username' 
		";
		$data = $this->get_data_from_db($sql);
		if(!empty($data))
		{
			$hash = $data[0]['otorisasi'];
			$nasabah_id = $data[0]['nasabah_id'];
			$nik = $data[0]['nik'];
			$nama = $data[0]['nama'];
			$username = $data[0]['username'];
			$telepon = $data[0]['telepon'];
			if(password_verify($password, $hash))
			{
				return array(
					'nasabah_id'=>$nasabah_id,
					'nik'=>$nik,
					'nama'=>$nama,
					'username'=>$username,
					'telepon'=>$telepon
					);
			} 
			else 
			{
				return null;
			}
		}
		else
		{
			return null;
		}
	}
	public function get_profile($name, $default_value = null)
	{
		$name = addslashes($name);
		$sql = "select * from profil where nama = '$name' ";
		$data = $this->get_data_from_db($sql);
		if($data != null && !empty($data))
		{
			return $data[0]['nilai'];
		}
		else
		{
			return $default_value;
		}
	}
	
	public function write_profile($name, $value)
	{
		$name = addslashes($name);
		$value = addslashes($value);
		$sql = "select * from profil where nama = '$name' ";
		if($this->get_num_row_from_db($sql))
		{
			$sql = "UPDATE `profil` SET 
			`nilai` = '$value'
			WHERE `nama` = '$name';
			";
			$this->execute_sql($sql);
		}
		else
		{
			$sql = "INSERT INTO `profil` 
				(nama, nilai) VALUES
				('$name', '$value');
			";
			$this->execute_sql($sql);
		}
	}
	public function get_account_data($nasabah_id)
	{
	}

}