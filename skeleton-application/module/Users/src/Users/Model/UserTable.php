<?php
namespace Users\Model;

use Zend\Db\Adapter\Adapter;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\TableGateway\TableGateway;

class UserTable
{
 protected $tableGateway;
 public function __construct(TableGateway $tableGateway)
 {
 $this->tableGateway = $tableGateway;
 }

 public function saveUser(User $user)
 {
	 $data = array(
		 'password' => $user->password,
		 'user' => $user->user,
	 );

 $id = (int)$user->id;
 if ($id == 0) {
 	$this->tableGateway->insert($data);
 } else {
	 if ($this->getUser($id)) {
	 	$this->tableGateway->update($data, array('id' => $id));
	 } else {
		 throw new \Exception('User ID does not exist');
		 }
	 }
 }
 public function getUser($id)
 {
	 $id = (int) $id;
	 $rowset = $this->tableGateway->select(array('id' => $id));
	 $row = $rowset->current();
	 if (!$row) {
	 	throw new \Exception("Could not find row $id");
	 }
	 return $row;
	 }
}