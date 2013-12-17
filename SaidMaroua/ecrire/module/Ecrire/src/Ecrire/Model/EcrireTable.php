<?php
namespace Ecrire\Model;

use Zend\Db\TableGateway\TableGateway;

class EcrireTable

{
	protected $tableGateway;

	public function __construct(TableGateway $tableGateway)
	{
		$this->tableGateway = $tableGateway;
	}

	public function fetchAll()
	{
		$resultSet = $this->tableGateway->select();
		return $resultSet;
	}

	public function getEcrire($id)
	{
		$id  = (int) $id;
		$rowset = $this->tableGateway->select(array('id' => $id));
		$row = $rowset->current();
		if (!$row) {
			throw new \Exception("Could not find row $id");
		}
		return $row;
	}

	public function saveEcrire(Ecrire $ecrire)
	{
		$data = array(
				'id' => $ecrire->id,
				'title'  => $ecrire->title,
		);

		$id = (int) $ecrire->id;
		if ($id == 0) {
			$this->tableGateway->insert($data);
		} else {
			if ($this->getEcrire($id)) {
				$this->tableGateway->update($data, array('id' => $id));
			} else {
				throw new \Exception('Ecrire id does not exist');
			}
		}
	}

	public function deleteEcrire($id)
	{
		$this->tableGateway->delete(array('id' => (int) $id));
	}
}

?>