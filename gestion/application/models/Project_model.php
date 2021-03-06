﻿<?php

class Project_model extends CI_Model
{
    public function __construct() 
    {
    	parent::__construct();
    	$this->load->database();
    }

    public function get_statuses()
    {
    	$this->load->database();
    	 
    	$query = $this->db->get('gestion.status');
    
    	$data=$query->result();
    
    	return $data;
    }
    
    public function get_projects($projectId=0) 
    {    	
    	if($projectId==0)
    	{	    	
	    	$query = $this->db->get('gestion.project');
	    	$data=$query->result();	 		    	
    	}
    	else 
    	{
    		$query = $this->db->get_where('gestion.project',array('project_id' => $projectId));
    		$data=$query->result();    		
    		
    		foreach ($data as $row)
    		{
    			//Obtenir le status
    			$statusId=$row->status_id;
    			$query = $this->db->get_where('gestion.project_status',array('status_id'=>$statusId));
    			$status=$query->row();
    			$row->status_id=$status->status;
    			 
    			//Obtenir le client
    			$clientId=$row->client_id;
    			$query = $this->db->get_where('gestion.client',array('client_id'=>$clientId));
    			$client=$query->row();
    			$row->client_id=$client->name." ".$client->surname;
    			 
    			//Obtenir l'auteur
    			$authorId=$row->author_author_id;
    			$query = $this->db->get_where('gestion.author',array('author_id'=>$authorId));
    			$author=$query->row();
    			$row->author_author_id=$author->prename." ".$author->name;
    		}
    	}        	
    	return $data;
    }

    public function set_project($id=0)
    {
    	if($id==0)    	
    	{
	    	$data = array(
				'title'=>$this->input->post('title'),
				'description'=>$this->input->post('descr'),
				'create_date'=>$this->input->post('create'),
				'client_id'=>$this->input->post('client'),
				'status_id'=>$this->input->post('status'),
				'author_author_id'=>$this->input->post('author')
	    	);
	    	$this->db->insert('gestion.project', $data);
    	}
    	else 
    	{
    		$data = array(
				'title'=>$this->input->post('title'),
				'description'=>$this->input->post('descr'),
				'author_author_id'=>$this->input->post('author'),
				'start_date'=>$this->input->post('start'),
				'end_date'=>$this->input->post('end'),
				'client_id'=>$this->input->post('client'),
				'status_id'=>$this->input->post('status')
	    	);
    		$this->db->where('project_id', $id);
    		$this->db->update('gestion.project', $data);
    	}
    }

    public function del_project($id)
    {    	
    	if($id==0)
    	{
    		
    	}
    	else 
    	{
    		$this->db->delete('gestion.project', array('project_id' => $id));
    	}    	   	
    }
   /*
    public function add_manager($author_id,$project_id) 
    {
    	
    	
    	$data=array(
    		'author_id'=>$author_id,
    		'project_id'=>$project_id
    	);
    	$this->db->insert('gestion.project_manager', $data);
    }

    public function del_manager($author_id,$project_id) 
    {
    	
    	$this->db->delete('gestion.project_manager', array('project_id' => $project_id,'author_id'=>$author_id));
    }*/
}
