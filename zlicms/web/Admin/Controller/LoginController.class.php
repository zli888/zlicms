<?php
namespace Admin\Controller;
use Think\Controller;
class LoginController extends Controller {
	public function login($username = null, $password = null, $verify = null){
		if(IS_POST)
		{
			if(!check_verify(I('verify')))
			{
				$this->error('验证码输入错误！');
			}   
			$admin = M("admin")->where(array('username'=>I('user')))->find();          
            if($admin && passport_decrypt($admin['password'],MYKEY) == I('password') && $admin['status']==1)
			{ 
                $auth = array(
                    'uid'             => $admin['uid'],
                    'username'        => $admin['username']
                ); 
                session('admin', $auth);
				$db = M('admin');
				$data['uid'] = $admin['uid'];
				$data['last_login_time'] = time();
				$data['last_login_ip'] = get_client_ip();
				$db->save($data);						
                $this->success('登录成功！', U('Index/index')); 
            }
			else
			{
				session('admin', null);
        		session('[destroy]');
                $this->error('用户不存在或被禁用！'); 
            }             
		}
		else
		{  
			$this->title = '管理员登录';
			$this->display();
        }
    }
    //退出登录 ,清除 session
    public function logout(){ 
        session('admin', null);
        session('[destroy]');
        $this->success('退出成功！', U('login')); 
    }
	//验证码
	public function verify(){
		$config =    array(    
			'seKey'     =>  'ThinkPHP.CN',   // 验证码加密密钥
			'codeSet'   =>  'ABCDEFGHJKLMNPQRTUVWXY',             // 验证码字符集合
			'expire'    =>  18000,            // 验证码过期时间（s）
			'useZh'     =>  false,           // 使用中文验证码
			'useImgBg'  =>  false,           // 使用背景图片 
			'fontSize'  =>  25,              // 验证码字体大小(px)
			'useCurve'  =>  true,            // 是否画混淆曲线
			'useNoise'  =>  true,            // 是否添加杂点	
			'imageH'    =>  0,               // 验证码图片高度
			'imageW'    =>  0,               // 验证码图片宽度
			'length'    =>  4,               // 验证码位数
			'fontttf'   =>  '4.ttf',              // 验证码字体，不设置随机获取
			'bg'        =>  array(243, 251, 254),  // 背景颜色
			'reset'     =>  false,           // 验证成功后是否重置 
		);
		ob_clean();
        $verify = new \Think\Verify($config);		
        $verify->entry(1);
    }
	//验证输入框
	public function is_verify($type=''){		   
		switch ($type)
		{
			case "user":
				$admin = M("admin")->where(array('username'=>$_POST["param"]))->find();
			  	echo $admin ? '{"info":"通过信息验证！","status":"y"}' : "用户名不存在！";
			  	break;			
			case "verify":
			  	echo check_verify($_POST["param"]) ? '{"info":"验证码正确！","status":"y"}' : "验证码错误！";
			  	break;
			default:
			  echo "y";
		}
    }	
}