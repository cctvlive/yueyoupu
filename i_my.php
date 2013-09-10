		public function sin_login()
		
		{
			include_once( 'saetv2.ex.class.php' );
		
			//print_r($this->config->item("WB_AKEY")."<br>");
		
			//print_r($this->config->item("WB_SKEY")."<br>");
		
			//print_r($this->config->item("WB_CALLBACK_URL"."<br>"));
		
			$o = new SaeTOAuthV2($this->config->item("WB_AKEY"), $this->config->item("WB_SKEY"));//用户点击新浪登录按钮调用此函数
		
			$code_url = $o->getAuthorizeURL( $this->config->item("WB_CALLBACK_URL") );
		
			//         print_r($code_url);
		
			redirect($code_url);
		
		
		
		}
		// 		function weibolist()
		function i_my()
		{
		
		
			include_once( 'saetv2.ex.class.php' );
		
			// 			$c = new SaeTClientV2($this->config->item("WB_AKEY"), $this->config->item("WB_SKEY"), $_SESSION['token']['access_token'] );
		
			// 			$ms  = $c->home_timeline(); // done
		
			// 			$uid_get = $c->get_uid();
		
			// 			$uid = $uid_get['uid'];
		
		
			// include_once APPPATH.'/libraries/lib/saetv2.ex.class.php'
				
            //print_r($_SESSION['token'])."<br />";
            //print_r($_SESSION['token']['access_token']);

			$c = new SaeTClientV2($this->config->item("WB_AKEY"), $this->config->item("WB_SKEY"), $_SESSION['token']['access_token'] );
			$ms  = $c->home_timeline(); // done
			$uid_get = $c->get_uid();
			$uid = $uid_get['uid'];
		
			$user_message['user_message'] = $c->show_user_by_id( $uid);//根据ID获取用户等基本信息
			
            //print_r($user_message['user_message']);
            
        $to_mysql=$user_message['user_message'];
           
				
            //print_r($user_message['user_message']);
			$query=$this->db->get('user');
			foreach($query->result() as $query){
				$access_token_key=$query->access_token_key;
			}
			
			
			if( isset($_SESSION['token']['access_token']) && $_SESSION['token']['access_token']===$access_token_key/*(是用户的唯一值) 等于 (匹配数据库里的access_token_key字段里的值)*/)
			{
			/*,就输出成功/跳转到指定页面(个人信息页面或者是 想让授权者到的第一页面)*/
				$select=array( 'access_token_key'=> $_SESSION['token']['access_token']);
				$user_message['user_message']=$this->db->get_where('user',$select);
                //print_r($user_message['user_message']);
                //  foreach($user_message['user_message']->result() as $user_message){
                //print_r($user_message);
                
                // }
				$this->load->view('load/i_my',$user_message);
			}
			else{
                
            if($to_mysql['gender']==='m'){$to_mysql['gender_demo']='男';} elseif($to_mysql['gender']==='f'){$to_mysql['gender_demo']='女';}elseif($to_mysql['gender']==='n'){$to_mysql['gender_demo']='未知';}
				$data=array(
			    'useradmin'=>$to_mysql['screen_name'],/*名称*/
				'u_img'=>$to_mysql['profile_image_url'],/*完整的头像地址*/
				'gender'=>$to_mysql['gender'],/* 性别,m--男，f--女,n--未知 */
                'gender_demo'=>$to_mysql['gender_demo'],/* 性别,m--男，f--女,n--未知 */
                
				'insrt'=>date('Y-m-d H:i:s ',mktime()),/*插入时间 */
				'access_token_key'=>$_SESSION['token']['access_token'],/*新浪key*/
                     'name'=>'新浪会员',
                    'type'=>'3',/*类*/
                    'group_id'=>'3'/*组*/
				);
				
				$this->db->insert('user',$data);
				if($this->db->affected_rows()>0){
					$select=array( 'access_token_key'=> $_SESSION['token']['access_token']);
					$user_message['user_message']=$this->db->get_where('user',$select);
                    // print_r($user_message['user_message']);
					$this->load->view('load/i_my',$user_message);
				}else {
                    $this->load->view('load/index');
				}
				//注册新的用户信息并绑定微博*/
				/*
				 * 将$c->show_user_by_id( $uid);查询出来的微博信息 和 
				 * 
				 * $_SESSION['token']['access_token']值  插入数据库 
				 * 
				 * 因密码用户授权时不可能得到微博用户的密码
				 * 
				 * 所以解决方法:  1   在网站的会员个人信息页面进行修改
				 *               2 在创建新用户时提示授权者输入密码 ,
				 *               插入数据库后再根据id读取出数据,
				 *               
				 *               json函数返回到js
				 *               输出读取出的数据到指定页面进行显示,
				 *             控制器结束  
				 *               
				 *               
				 *               js:
				 *               接收控制器里的值
				 *               
				 *               js再把值传到对应的位置上
				 *               
				 *               3秒后显示弹窗id
				 *               
				 *               
				 *               利用弹窗弹出修改密码的表单
				 *               最后提交!
				 * 
				 * 
				 * /注册新的用户信息并绑定微博完成!
				 * 
				 * 
				 * 
				 * 
				 * 
				 * 
				 * 
				 * 
				 * 
				 * 
				 * 
				 * */
				
			}
			
			
			
            //print_r($user_message['user_message']);
			//$key['akey']=$this->config->item("WB_AKEY");
			// $key['skey']=$this->config->item("WB_SKEY");
			// 			$this->load->view('load/weibolist',$user_message);
            //$this->load->view('load/i_my',$user_message);
		}

		
		
    	public function qw()
	 {
	 	//$WB_AKEY=$this->config->item('WB_AKEY');
	 	//$WB_SKEY=$this->config->item('WB_SKEY');
	 	//$WB_CALLBACK_URL=$this->config->item('WB_CALLBACK_URL');
	 	//$this->load->library('SaeTOAuthV2');
	 	//$o=$this->SaeTOAuthV2->SaeTOAuthV2($WB_AKEY,$WB_SKEY);
	 	//$data['code_url'] = $o->getAuthorizeURL( $WB_CALLBACK_URL );
	 	//$this->load->view('load/load',$data);
	 	$this->load->view('load/load');
	 }
	/**
	 * 点击QQ登陆页面操作
	 */
	public function qqlogin()
	{
		$qq_state = md5(uniqid(rand(), TRUE)); //CSRF protection
		$this->qqclass->qq_login($qq_state, $this->config->item("qq_appid"), $this->config->item("qq_scope"), $this->config->item("qq_callback"));//用户点击qq登录按钮调用此函数	
	}
	/**
	 * QQ登陆返回到本网站
	 */
	public function qqcallback()
	{
		$inputs = $this->input->get();
		$access_token = $this->qqclass->qq_callback($inputs, $this->config->item("qq_appid"), $this->config->item("qq_appkey"), $this->config->item("qq_callback"));//QQ登录成功后的回调地址,主要保存access token
		$open_id = $this->qqclass->get_openid($inputs, $access_token);//获取用户标示id
		
		//获取用户基本资料

         $data['qq'] = $this->qqclass->get_user_info($access_token, $this->config->item("qq_appid"), $open_id);//QQ空间
        //$data['data'] = $this->qqclass->get_info($access_token, $this->config->item("qq_appid"), $open_id);//微博
        // print_r($data['qq']);die(); //全部数据
        //print_r($data['data']); //全部数据
        //echo '<br />';
        //print_r($data['data']['data']['openid']); //唯一id 与name对应
        //echo '<br />';
        //   print_r($data['data']['data']);//用户数据
        //  $to_mysql=$data['data']['data'];
         $to_mysql=$data['qq'];
        // print_r($to_mysql);
        $query=$this->db->get('user');
        foreach($query->result() as $query){
        		$username=$query->useradmin;
            //  print_r($query);
            // print_r($query->useradmin);
        	}
        // print_r($to_mysql['nickname']);
        //  /$_SESSION=array('head'=>$data['data']['head'] ,'nick'=>$data['data']['nick'],'data'=>$data['data']['data']);
         if( isset($username) && $username==$to_mysql['nickname']/*(是用户的唯一值) 等于 (匹配数据库里的openid字段里的值)*/)
          {
			/*,就输出成功/跳转到指定页面(个人信息页面或者是 想让授权者到的第一页面)*/
                	$select=array( 'useradmin'=> $to_mysql['nickname']);
              $user_message['user_message']=$this->db->get_where('user',$select);
                  // print_r($user_message['user_message']);
             foreach($user_message['user_message']->result() as $user_message){
             print_r($user_message->useradmin);
                 print_r($user_message->u_img);
                 print_r($user_message->gender_demo);
                 print_r($user_message->name);
                 $user_data['data']=array('username'=>$user_message->useradmin,
                                  'u_img'=>$user_message->u_img,
                                  'gender_demo'=>$user_message->gender_demo,
                                  'name'=>$user_message->name,
                                 );
                 
              }
             $this->load->view('load/i_my',$user_data);
             //echo 'oooooooooooooooooooooooooo'; 	
         }else{// echo 'ppppppppppppppppppp<br />';
               // print_r($to_mysql['nick']);
             // print_r($to_mysql['nickname']);
                                                         
               // print_r($to_mysql['openid']);
                                                           
         
               // if($to_mysql['gender']=='男';){$to_mysql['sex']='m'}
               //if($to_mysql['gender']=='女';){$to_mysql['sex']='f'}
               //if($to_mysql['gender']=='未知';){$to_mysql['sex']='n'}
               //$to_mysql['https_head']=$to_mysql['https_head'].'/100';	
               // print_r($to_mysql['https_head']);
               // print_r($to_mysql['gender']);
        //   print_r($to_mysql['sex']);
                $data=array(
                'useradmin'=>$to_mysql['nickname'],/*名称*/
                 'u_img'=>$to_mysql['figureurl_2'],/*完整的头像地址*/
                    // 'gender'=>$to_mysql['sex'],/* 性别,m--男，f--女,n--未知 */
                 'gender_demo'=>$to_mysql['gender'],/* 性别,m--男，f--女,n--未知 */
                 'insrt'=>date('Y-m-d H:i:s ',mktime()),/*插入时间 */
               
                  'name'=>'腾讯会员','type'=>'2',/*类*/'group_id'=>'2'/*组*/);
               
                                                         $this->db->insert('user',$data);
                                                          if($this->db->affected_rows()>0){
                    		$select=array( 'useradmin'=> $to_mysql['nickname']);
              $user_message['user_message']=$this->db->get_where('user',$select);
                  // print_r($user_message['user_message']);
             foreach($user_message['user_message']->result() as $user_message){
             print_r($user_message->useradmin);
                 print_r($user_message->u_img);
                 print_r($user_message->gender_demo);
                 print_r($user_message->name);
                 $user_data['data']=array('username'=>$user_message->useradmin,
                                  'u_img'=>$user_message->u_img,
                                  'gender_demo'=>$user_message->gender_demo,
                                  'name'=>$user_message->name,
                                 );
                 
              }
             $this->load->view('load/i_my',$user_data);
                 }else {
                $this->load->view('load/index');
                     }
		
		//print_r($_SESSION['head']);die();
       // $this->db->where('status' , 1)->where('type' ,4)->order_by('aboutus_id','desc')->limit(1)->select("*");
			//$data['query']=$this->db->get('user');
			//print_r($query);
        
           }
        
        
        
        
        
        
        
        
                          // $this->load->view('load/i_my',$data);
	}
