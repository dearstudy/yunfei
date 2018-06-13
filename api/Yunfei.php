<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Yunfei extends MY_Controller {

	public function index()
	{

	}

	public function admin()
	{
		if (FALSE === $this->input->is_ajax_request())
		{
			$this->output->json(array('code' => 10000, 'error' => '不正确请求'));
		}

		$account = $this->input->post('account');
		if(FALSE === isset($account))
		{
			$this->output->json(array('code' => 10000, 'error' => '缺失参数[账号]'));
		}

		$password = $this->input->post('password');
		if(FALSE === isset($password))
		{
			$this->output->json(array('code' => 10000, 'error' => '缺失参数[密码]'));
		}

		if($account == '2018' && $password == 'itbldcom')
		{
			$this->output->json(array('code' => 0, 'data' => '允许登录'));
		}
		$this->output->json(array('code' => 10000, 'error' => '不允许操作'));
	}

	public function login()
	{
		if (FALSE === $this->input->is_ajax_request())
		{
			$this->output->json(array('code' => 10000, 'error' => '不正确请求'));
		}

		$account = $this->input->post('account');
		if(FALSE === isset($account))
		{
			$this->output->json(array('code' => 10000, 'error' => '缺失参数[账号]'));
		}

		$password = $this->input->post('password');
		if(FALSE === isset($password))
		{
			$this->output->json(array('code' => 10000, 'error' => '缺失参数[密码]'));
		}

		$this->load->model('yunfei/Yunfei_model');
		$data = array('phone' => $account, 'card' => $password);
		$result = $this->Yunfei_model->login($data);
		$this->output->json($result);
	}

	// 注册
	public function register()
	{
		if (FALSE === $this->input->is_ajax_request())
		{
			$this->output->json(array('code' => 10000, 'error' => '不正确请求'));
		}

		$filename = $this->input->post('filename');
		if(FALSE === isset($filename))
		{
			$this->output->json(array('code' => 10000, 'error' => '缺失参数[0]'));
		}

		$myfile = $this->input->post('myfile');
		if(FALSE === isset($myfile))
		{
			$this->output->json(array('code' => 10000, 'error' => '缺失参数[1]'));
		}

		$name = $this->input->post('name');
		if(FALSE === isset($name))
		{
			$this->output->json(array('code' => 10000, 'error' => '缺失参数[2]'));
		}

		$phone = $this->input->post('phone');
		if(FALSE === isset($phone))
		{
			$this->output->json(array('code' => 10000, 'error' => '缺失参数[3]'));
		}

		$card = $this->input->post('card');
		if(FALSE === isset($card))
		{
			$this->output->json(array('code' => 10000, 'error' => '缺失参数[4]'));
		}

		$sex = $this->input->post('sex');
		if(FALSE === isset($sex))
		{
			$this->output->json(array('code' => 10000, 'error' => '缺失参数[5]'));
		}

		$borthday = $this->input->post('borthday');
		if(FALSE === isset($borthday))
		{
			$this->output->json(array('code' => 10000, 'error' => '缺失参数[6]'));
		}

		$weight = $this->input->post('weight');
		if(FALSE === isset($weight))
		{
			$this->output->json(array('code' => 10000, 'error' => '缺失参数[7]'));
		}

		$path =  FCPATH . "static/yunfei/avatar/";
		$result = $this->uploadBase64($myfile, $path, $filename);
		if(TRUE == $result)
		{
			$filename = base_url() . "static/yunfei/avatar/" . $filename;
			$this->load->model('yunfei/Yunfei_model');
			$data = array('names' => $name,
							'phone' => $phone,
							'cards' => $card,
							'sex' => $sex,
							'borthdays' => $borthday,
							'weight' => $weight,
							'image_name' => $filename);

			$result = $this->Yunfei_model->register($data);
			$this->output->json($result);
		}
		$this->output->json(array('code' => 10000, 'error' => '上传头像错误[8]'));
	}

	// 注册
	public function signup()
	{
		if (FALSE === $this->input->is_ajax_request())
		{
			$this->output->json(array('code' => 10000, 'error' => '不正确请求'));
		}

		$phone = $this->input->post('phone');
		if(FALSE === isset($phone))
		{
			$this->output->json(array('code' => 10000, 'error' => '缺失参数[0]'));
		}

		$changg = $this->input->post('changg');
		if(FALSE === isset($changg))
		{
			$this->output->json(array('code' => 10000, 'error' => '缺失参数[1]'));
		}

		$this->load->model('yunfei/Yunfei_model');
		$data = array('localtimes' => $changg,'phone' => $phone);
		$result = $this->Yunfei_model->signup($data);
		$this->output->json($result);
	}

	public function ranking()
	{
		if (FALSE === $this->input->is_ajax_request())
		{
			$this->output->json(array('code' => 10000, 'error' => '不正确请求'));
		}

		$this->load->model('yunfei/Yunfei_model');
		$result = $this->Yunfei_model->ranking();
		$this->output->json($result);
	}

	public function upranking()
	{
		if (FALSE === $this->input->is_ajax_request())
		{
			$this->output->json(array('code' => 10000, 'error' => '不正确请求'));
		}

		$wins = $this->input->post('wins');
		if(FALSE === isset($wins))
		{
			$this->output->json(array('code' => 10000, 'error' => '缺失参数[0]'));
		}

		$loser = $this->input->post('loser');
		if(FALSE === isset($loser))
		{
			$this->output->json(array('code' => 10000, 'error' => '缺失参数[1]'));
		}

		$counts = $this->input->post('counts');
		if(FALSE === isset($counts))
		{
			$this->output->json(array('code' => 10000, 'error' => '缺失参数[2]'));
		}

		$phone = $this->input->post('phone');
		if(FALSE === isset($phone))
		{
			$this->output->json(array('code' => 10000, 'error' => '缺失参数[3]'));
		}

		$this->load->model('yunfei/Yunfei_model');
		$result = $this->Yunfei_model->upranking(array('wins' => $wins, 'loser' => $loser, 'counts' => $counts), $phone);
		$this->output->json($result);
	}

	private function uploadBase64($basestr, $path, $name)
	{
		if (preg_match('/^(data:\s*image\/(\w+);base64,)/', $basestr, $result))
		{
			$type = $result[2];

			if (!file_exists($path))
			{
				mkdir($path, 0777, TRUE);
			}

			//写入操作
			if (file_put_contents($path.$name, base64_decode(str_replace($result[1], '', $basestr))))
			{
				return true;
			}
			else
			{
				return false;
			}
		}
		return false;
	}

}
