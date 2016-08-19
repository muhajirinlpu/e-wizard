<?php 

class CORE
{
	
	private static $config = array(
							"host"	=>	"localhost",
							"dbname"=>	"ewizard",
							"uname"	=>	"root",
							"pass"	=>	"9514"
	);

	private static $conn ;

	public static function Go(){
		try {
			$host = self::$config['host'];
			$dbname = self::$config['dbname'];
			$conn = new PDO("mysql:host=$host;dbname=$dbname;",self::$config['uname'],self::$config['pass']);
			$conn->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
			return self::$conn = $conn ;
		} catch (PDOException $e) {
			echo $e->getMessage();
		}
	}

	public static function runQuery($query,$val=array()){
		if(empty(self::$conn)) self::Go();
		try {
			$stmt = self::$conn->prepare($query);
			$stmt->execute($val);
			return $stmt ;
		} catch (PDOException $e) {
			echo $e->getMessage();
		}
	}

	public static function fetchQuery($arg,$query){
		if($arg==1) return $query->fetch(PDO::FETCH_ASSOC);
		else 		return $query->fetchAll(PDO::FETCH_ASSOC);
	}

	public static function response($arg,$rsp,$msg){
		if($arg==1) return array("response"=>$rsp,"message"=>$msg);
		else 		return json_encode(array("response"=>$rsp,"message"=>$msg));
	}

}

class APP
{
	
	public static function redirect($location){
		return header("location:$location");
	}

	public static function upload($formName){
		$location = $GLOBALS['app_path']."assets/uploads/";
		$name = $_FILES[$formName]['name'] ;
		if (move_uploaded_file($_FILES[$formName]['tmp_name'], $location.$name)) {
			return self::response(1,1,$name);
		}else{
			return self::response(1,0,"Error while uploads");
		}
	}

	public static function custom_echo($str,$length){
		if(strlen($str)<=$length){
	    	echo $str;
	  	}else{
		    $y=substr($str,0,$length) . '...';
		    echo $y;
	  	}
	}

}

class CART extends CORE
{
	
	public static function init(){
		
		return $_SESSION['cart']=array();
	}

	public static function add($id){
		
		$_SESSION['cart'][] = $id ;
	}

	public static function delete($id){
		
		foreach ($_SESSION['cart'] as $key => $value) {
			if ($value==$id) {
				unset($_SESSION['cart'][$key]);
			}
		}
	}

	public static function count(){
		return sizeof($_SESSION['cart']);
	}

	public static function see(){
		
		if (empty($_SESSION['cart'])) {
			return self::response(1,0,"No cart you select");
		}
		$val = array();
		$query = "SELECT id_barang,merk,type FROM barangdata WHERE ";
		foreach ($_SESSION['cart'] as $key => $value) {
			if($key == 0) $query += " id_barang = ? ";
			else 		  $query +=	" OR id_barang = ? ";
			$val[] = $value ;
		}
		$stmt = self::runQuery($query,$val);
		if ($stmt->rowCount()>0) {
			return self::response(1,1,self::fetchQuery(2,$stmt));
		}else{
			return self::response(1,0,"Something error");
		}
	}

}

class ADMIN extends CORE
{
	
	public static function Login($uname,$pass){
		$stmt = self::runQuery("SELECT * FROM admindata where username = ? AND password = ?",array($uname,$pass));
		if ($stmt->rowCount()==1) {
			$data = self::fetchQuery(1,$stmt);
			
			$_SESSION['admindata'] = $data;
			return self::response(1,1,"Login success");
		}else{
			return self::response(1,0,"Wrong username or password");
		}
	}

	public static function Logout(){
		
		unset($_SESSION['admindata']);
	}

	public static function addCategory($name){
		$stmt = self::runQuery("INSERT INTO `kategori`(`name`) VALUES (?)",array($name));
		if($stmt) return self::response(1,1,"Success add kategori");
		else 	  return self::response(1,0,"failed add kategori");
	}

	public static function addBarang($merk, $type, $spoiler, $stok, $harga, $kategori, $formName){
		$uploads = self::uploads($formName);
		$keyword = $merk . " " . $type . " " . $spoiler . " ";
		if ($uploads['response']==1) {
			$stmt = self::runQuery("INSERT INTO `barangdata`(`merk`, `type`, `spoiler`, `stok`, `harga`, `kategori`, `picture`, `keyword`) VALUES (?,?,?,?,?,?,?,?)",array($merk, $type, $spoiler, $stok, $harga, $kategori,$uploads['message'],$keyword));
			return self::response(1,1,"Success add barang");
		}
	}

	public static function seePesanan(){
		$stmt = self::runQuery("SELECT A.`id_order`, C.nama , C.alamat, C.phone , B.merk , B.type , A.`status`, A.`time_update` FROM `orderdata` AS A, `barangdata` AS B , `userdata` AS C WHERE A.id_barang = B.id_barang AND A.id_user = C.id_user ORDER BY status ASC");
		if($stmt->rowCount() > 0){
			$data = self::fetchQuery(2,$stmt);
			return self::response(1,1,$data);
		}else{
			return self::response(1,0,"no result");
		}
	}

	public static function responPesanan($id){
		$before = self::fetchQuery(1,self::runQuery("SELECT status FROM orderdata WHERE id_order = ?",array($id)));
		$before++;
		if(self::runQuery("UPDATE `orderdata` SET `status` = ? WHERE id_order = ?",array($before,$id))){
			return self::response(1,1,"Success response");
		}else{
			return self::response(1,0,"Failed response");
		}
	}

	public static function isLogin(){
		if (isset($_SESSION['admindata'])) {
			return true;
		}else{
			return false;
		}
	}

	public static function getName(){
		return $_SESSION['admindata']['show_name'];
	}
}


class USER extends CORE
{
	public static function Login($uname,$pass){
		$stmt = self::runQuery("SELECT id_user,username,nama,alamat,phone FROM userdata where username = ? AND password = ?",array($uname,$pass));
		if ($stmt->rowCount()==1) {
			$data = self::fetchQuery(1,$stmt);
			
			$_SESSION['userdata'] = $data;
			return self::response(1,1,"Login success");
		}else{
			return self::response(1,0,"Wrong username or password");
		}
	}

	public static function Register($uname,$pass,$name,$alamat,$phone){
		$stmt = self::runQuery("INSERT INTO `userdata`(`username`, `password`, `nama`, `alamat`, `phone`) VALUES (?,?,?,?,?)",array($uname,$pass,$name,$alamat,$phone));
		if ($stmt) return self::response(1,1,"Successs added");
		else 	   return self::response(1,0,"Failed register");
	}

	public static function isLogin(){
		
		if(isset($_SESSION['userdata'])){
			return true;
		}else{
			return false;
		}
	}

	public static function Logout(){
		
		unset($_SESSION['userdata']);
	}

	public static function seeProfile(){
		
		return self::response(1,1,$_SESSION['userdata']);
	}

	public static function updateProfile($update = array()){
		
		$sql = "UPDATE `userdata` SET ";
		$a = 1 ;
		$val = array();
		foreach ($update as $key => $value) {
			if($a==1) $sql .= " $key = ?";
			else 	  $sql .= " , $key = ? ";
			$a++ ;
			$val[] = $value ;
		}

		$sql .= "WHERE id_user = ?" ;
		$val[] = $_SESSION['userdata']['id_user'];

		if (self::runQuery($sql , $val)) {
			return self::response(1,1,"SUCCESS UPDATE");
		}else{
			return self::response(1,0,"Failed");
		}
	}

	public static function historyPesanan(){
		
		$stmt = self::runQuery("SELECT A.id_order,B.merk,B.type,B.harga,A.status,A.time_update FROM `orderdata` AS A , `barangdata` AS B WHERE A.id_barang = B.id_barang");
		if ($stmt->rowCount()>0) {
			$data = self::fetchQuery(2,$stmt);
			return self::response(1,1,$data);
		}else{
			return self::response(1,0,"No result found !!");
		}
	}
}

class ITEM extends CORE
{
	 
	public static function seeFavorite(){
		$stmt = self::runQuery("SELECT id_barang,merk,type,spoiler,harga,picture FROM barangdata ORDER BY show_counter DESC LIMIT 5");
		if ($stmt->rowCount()>0) {
			$data = self::fetchQuery(2,$stmt);
			return self::response(1,1,$data);
		}
	}

	public static function updateFavorite($id){
		$before = self::fetchQuery(1,self::runQuery("SELECT show_counter FROM barangdata WHERE id_barang = ?",array($id)));
		$before++ ;
		if(self::runQuery("UPDATE `barangdata` SET `show_counter`= ? WHERE id_barang = ?",array($before,$id))){
			return true;
		}
	}

	public static function seeDetail($id){
		$stmt = self::runQuery("SELECT * FROM userdata WHERE id_barang = ?",array($id));
		if ($stmt->rowCount()==1) {
			self::updateFavorite($id);
			$data = self::fetchQuery(1,$stmt);
			return self::response(2,1,$data);
		}else{
			return self::response(2,0,"No result found !!");
		}
	}

	public static function search($q){
		$stmt = self::runQuery("SELECT id_barang,merk,type,spoiler,harga,picture FROM barangdata WHERE keyword = %$q%");
		if ($stmt->rowCount()>0) {
			$data = self::fetchQuery(2,$stmt);
			return self::response(1,1,$data);
		}else{
			return self::response(1,0,"No result found !!");
		}
	}

	public static function buy(){
		
		foreach ($_SESSION['cart'] as $key => $value) {
			self::runQuery("INSERT INTO `orderdata`(`id_user`, `id_barang`) VALUES (?,?)",array($_SESSION['userdata']['id_user'],$value));
		}
		return true;
	}

	public static function category(){
		$stmt = self::runQuery("SELECT * FROM kategori");
		return self::response(1,1,self::fetchQuery(2,$stmt));
	}
	
	public static function Paging($page,$query,$limit){
		$set = $page*$limit-$limit ;
		$stmt = self::runQuery("$query LIMIT $limit OFFSET $set");
		$data = self::fetchQuery(2,$stmt);

		$msg = array("page"=>$page,"total"=> ceil($stmt->rowCount()),"data"=>$data);
		return self::response(1,1,$msg);
	}

	public static function seeAsCategory($id){
		return self::Paging($p,"SELECT id_barang,merk,type,spoiler,harga,picture FROM barangdata WHERE kategori = $id ORDER BY time_added DESC",10);
	}

	public static function seeAll($p=1){
		return self::Paging($p,"SELECT id_barang,merk,type,spoiler,harga,picture FROM barangdata ORDER BY time_added DESC",10);
	}

}