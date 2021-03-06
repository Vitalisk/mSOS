<?php
class User extends Doctrine_Record {

	public function setTableDefinition() {
		$this->hasColumn('id', 'int', 11);
		$this->hasColumn('fname', 'varchar', 255);
		$this->hasColumn('email', 'Text', 255, array('unique' => 'true'));
		$this->hasColumn('username', 'Text', 255, array('unique' => 'true'));
		$this->hasColumn('password', 'Text', 255);
		$this->hasColumn('usertype_id', 'integer', 11);
		$this->hasColumn('telephone', 'varchar', 255);
		$this->hasColumn('rrt_sms', 'int', 2);
		$this->hasColumn('county', 'varchar', 255);
		$this->hasColumn('district', 'varchar', 255);
		$this->hasColumn('facility', 'varchar', 255);
		$this->hasColumn('created_at', 'varchar', 255);
		$this->hasColumn('status', 'int', 1);
		$this->hasColumn('reset_token', 'Text');
		$this->hasColumn('token_generated', 'datetime');
		
	}
	
	public function setUp() {
		$this->setTableName('user');
		$this->actAs('Timestampable');
		$this->hasMutator('password', '_encrypt_password');
		$this -> hasOne('logi as logss', array('local' => 'id', 'foreign' => 'user_id'));
		$this -> hasOne('blog as bloger', array('local' => 'id', 'foreign' => 'user_id'));
			
	}

	protected function _encrypt_password($value) {
		$salt = '#*seCrEt!@-*%';
		$this->_set('password', md5($salt . $value));
		
	}
	
	public function login($username, $password) {
        $salt = '#*seCrEt!@-*%';
		$password = ( md5($salt . $password));
		$query = Doctrine_Query::create() -> select("*") -> from("User") -> where("username = '" . $username . "' and password='". $password ."'");
		$results = $query -> execute();
		return $results[0];
	}
	public static function getsome($id) {
		$query = Doctrine_Query::create() -> select("fname") -> from("user")->where("id='$id' ");
		$level = $query -> execute();
		return $level;
	}
	public static function getAll2($facility,$id) {
		$query = Doctrine_Query::create() -> select("*") -> from("user")->where("usertype_id=2 or usertype_id=5 ")->andWhere("id <> $id and facility='$facility'");
		$level = $query -> execute();
		return $level;
	}
	public static function getAll3($use_id) {
		$query = Doctrine_Query::create() -> select("*") -> from("user")->where("usertype_id=2 and id=$use_id");
		$level = $query -> execute();
		return $level;
		
	}
	public static function getAll4($use_id) {
		$myobj = Doctrine::getTable('user')->findOneById($use_id);
        $id=$myobj->id ;
		$my_array =array('0'=>$id);
		return $my_array;
	}
	public static function getAll(){
		$query = Doctrine_Query::create() -> select("*") -> from("user")->orderBy('usertype_id');;
		$level = $query -> execute();
		return $level;
	}
	public static function getAll5($district, $id){
		$query = Doctrine_Query::create() -> select("*") -> from("user")->where("district=$district") ->andWhere("id <> $id");
		$level = $query -> execute();
		return $level;
	}
	public static function getUsers($facility_c){
		$query = Doctrine_Query::create() -> select("*") -> from("user")->where("facility=$facility_c");
		$level = $query -> execute();
		return $level;
	}
	public static function getAllUser($use_id){
		$query = Doctrine_Query::create() -> select("*") -> from("user")->where("id=$use_id");
		$level = $query -> execute();
		return $level;
	}
	public function admin(){
		$query = Doctrine_Query::create() -> select("*") -> from("user")->where("usertype_id =1 OR usertype_id =2");
		$admin = $query -> execute();
		return $admin;
	}
	public function get_usertype($user_id){
	    $query = Doctrine_Query::create() -> select("*") -> from("access_level")->where("id=$user_id");
		$user_type= $query -> execute();
		return $user_type;
	}
	public function ebola_Kemri_receivers(){
		//$query = Doctrine_Query::create() -> select("telephone") -> from("user")->where("telephone='254729928476' AND status=1");
		$query = Doctrine_Query::create() -> select("telephone") -> from("user")->where("(sms='1' OR sms='2') AND status='1'");
		$user_type= $query -> execute();
		return $user_type;
	}
	public function get_userbyEmail($email){
		$query = Doctrine_Query::create() -> select("fname") -> from("user")->where("email='$email'");
		$user_type= $query -> fetchOne(array(), Doctrine::HYDRATE_SCALAR);
		return $user_type;
	}
	public function Ebola_RRT_users(){
	$query = Doctrine_Query::create() -> select("fname,email,username") -> from("user")->where("sms='2' AND status='1' AND ebola_login='1'");
		$user_type= $query -> execute();
		return $user_type;	
	}
	public function getByUsername($username){
	    $query = Doctrine_Query::create() -> select("fname") -> from("user")->where("username='$username'");
		$user_type= $query -> execute();
		return $user_type;	
	}
	public function count_users(){
		$query = Doctrine_Query::create() -> select("count(id) as total") -> from("user")->where("status='1'");
		$user_type= $query -> execute(array(), Doctrine::HYDRATE_SINGLE_SCALAR);
		return $user_type;	
	}
	public function get_userBy_token($token){
		$query = Doctrine_Query::create() -> select("token_generated") -> from("user")->where("reset_token='$token'");
		$user_type= $query -> execute(array(), Doctrine::HYDRATE_SINGLE_SCALAR);
		return $user_type;
	}
}
