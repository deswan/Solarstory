<?php
namespace Home\Controller;
use Think\Controller;
class UserController extends Controller{
	//登陆会话id:username
	public function index(){
		if(\think\Session::has('username')){
			return \think\Session::get('username');
		}
		else{

			return false;
		}
	}
	public function homepage(){

	}
	public function ajaxGetLoginStatus(){
		if(session('?userid')) $data = 'true';
		else $data = 'false';
		// dump('ss');
		$this->ajaxReturn($data);
	}
	private function check_verify($code){
		$verify = new \Think\Verify();
		$res = $verify->check($code);
		return $res;
	}
	//login=>登陆
	public function login(){
		//已登录排除（测试中先不写）

		//空表单排除
		if(!IS_POST||!I('post.username','')||!I('post.password','')||!I('post.verify')) return;

		$username = I('post.username/s');
		$password = I('post.password/s');

		$code = I('post.verify/s');
		if(!$this->check_verify($code)) $this->error('验证码有误');
		$MUser = D('User');
		$vali_result = $MUser->valiLogin($username,$password);
		switch ($vali_result) {
			case 0:$this->error('用户名不存在');break;
			case -1:$this->error('密码不正确');break;
			default:session('userid',"$vali_result");
				$this->redirect('story/index');
				break;
		}
	}
	//signup=>签约（注册）
	public function signup(){
		if(!IS_POST||!I('post.username','')||!I('post.password','')||!I('post.verify')) return;
		$code = I('post.verify/s');
		if(!$this->check_verify($code)) {
			return $this->error('s');
		}
		$MUser = D('User');
		if(!$MUser->create()){
			return $this->error($MUser->getError());
		}
		if($uid = $MUser->add()){
			session('userid',$uid);
			$this->redirect('story/index');
		}
	}
	public function logout(){
		if(session('?userid')){
			session('userid',null);
		}
		$this->redirect('story/index');
	}
	public function ajaxifUsernameExist($name){
		$name = I('get.name');
		if(!$name) return;
		if(!M('user')->where(['username'=>$name])->find()){
			$this->ajaxReturn(0);	//可注册
		}
		else{$this->ajaxReturn(1);};	//不能注册
	}
	public function ajaxCheckVerify(){
		$code = I('get.code');
		if(!isset($code)) return;
		$verify = new \Think\Verify(['reset'=>false]);
		$res = $verify->check($code);
		$this->ajaxReturn($res);
	}
	public function  ajaxCheckLogin(){
		$username = I('post.username/s');
		$password = I('post.password/s');
		if(!isset($username,$password)){return;};
		if(D('user')->valiLogin($username,$password)){
			$this->ajaxReturn(1);
		}else{
			$this->ajaxReturn(0);
		}
	}

	public function ajaxAddIP(){
		$ip = get_client_ip();
		if(!M('ip')->where(['ip'=>$ip])->find()) {
			M('ip')->add(['ip' => $ip]);
			$this->ajaxReturn(1);
		}
		else{
			$this->ajaxReturn(0);
		}
	}
}
?>