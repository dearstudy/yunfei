<?php

class Yunfei_model extends CI_Model
{
	private $db = NULL;

	public function __construct()
	{
		parent::__construct();

		$this->db = $this->load->database('yunfei', TRUE);
		if (FALSE === $this->db->conn_id)
		{
			return array('code'=>10000 , 'error'=>'数据库连接失败');
		}
	}

	public function __destruct()
	{
		if (isset($this->db))
		{
			$this->db->close();
			$this->db = NULL;
		}
	}

	public function login($value)
	{
		$phone = $value['phone'];
		if(FALSE === isset($phone))
			return array('code'=>10000 , 'error'=>'缺少电话号码');

		$card = $value['card'];
		if(FALSE === isset($card))
			return array('code'=>10000 , 'error'=>'缺少身份证号码后六位');

		$query = $this->db->query('select `cards` from `user` where `phone` = ' . $phone);
		if(FALSE == $query){
				return array('code' => 10000, 'error' => '查询错误');
		}
		$row = $query->row();

		if (FALSE ==  isset($row))
		{
    		return array('code' => 10000, 'error' => '请先报名');
		}
		$rawcard = $row->cards;

		if(FALSE == isset($rawcard))
		{
				return array('code' => 10000, 'error' => '异常错误，没身份证号码');
		}

		if($card == substr($rawcard, -6))
		{
				return array('code' => 0, 'error' => '登录成功');
		}
		return array('code' => 10000, 'error' => '求求你，打打我吧！');
	}

	public function register($value)
	{
		$phone = $value['phone'];
		if(FALSE === isset($phone))
			return array('code'=>10000 , 'error'=>'缺少电话号码');

		$cards = $value['cards'];
		if(FALSE === isset($cards))
			return array('code'=>10000 , 'error'=>'缺少身份证号码');

		$query = $this->db->get_where('user', array('phone' => $phone));
		if ($query->num_rows() > 0)
		{
			return array('code'=>10000 , 'error'=>'该电话号码已经报名了');
		}

		$query = $this->db->get_where('user', array('cards' => $cards));
		if ($query->num_rows() > 0)
		{
			return array('code'=>10000 , 'error'=>'该身份证号码已经报名了');
		}

		$query = $this->db->insert('user', $value);
		if ($query == FALSE)
		{
			return array('code' => 10000, 'error' => '注册失败');
		}
		return array('code' => 0, 'error' => '注册成功');
	}

	public function signup($value)
	{
		$phone = $value['phone'];
		if(FALSE === isset($phone))
			return array('code'=>10000 , 'error'=>'缺少电话号码');

		$localtimes = $value['localtimes'];
		if(FALSE === isset($localtimes))
			return array('code'=>10000 , 'error'=>'缺少场馆');

		$query = $this->db->where('phone', $phone)->update('user', array('localtimes' => $localtimes));
		if(FALSE ==$query)
		{
			return array('code' => 10000, 'error' => '报名失败');
		}
		return array('code' => 0, 'error' => '报名成功');
	}

	public function ranking()
	{
		$query = $this->db->select('*')->from('user')->order_by('counts', 'DESC')->get();
		if(FALSE == $query)
		{
			return array('code' => 10000, 'error' => '查询失败');
		}
		$data = $query->result_array();
		return array('code' => 0, 'attr' => $data);
	}

	public function upranking($data, $phone)
	{
		$query = $this->db->where('phone', $phone)->update('user', $data);
		if(FALSE ==$query)
		{
			return array('code' => 10000, 'error' => '设置失败');
		}
		return array('code' => 0, 'error' => '设置成功');
	}
}
