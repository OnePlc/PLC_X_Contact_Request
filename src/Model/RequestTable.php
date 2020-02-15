<?php
/**
 * RequestTable.php - Request Table
 *
 * Table Model for Request Request
 *
 * @category Model
 * @package Contact\Request
 * @author Verein onePlace
 * @copyright (C) 2020 Verein onePlace <admin@1plc.ch>
 * @license https://opensource.org/licenses/BSD-3-Clause
 * @version 1.0.0
 * @since 1.0.0
 */

namespace OnePlace\Contact\Request\Model;

use Application\Controller\CoreController;
use Application\Model\CoreEntityTable;
use Laminas\Db\TableGateway\TableGateway;
use Laminas\Db\ResultSet\ResultSet;
use Laminas\Db\Sql\Select;
use Laminas\Db\Sql\Where;
use Laminas\Paginator\Paginator;
use Laminas\Paginator\Adapter\DbSelect;

class RequestTable extends CoreEntityTable {

    /**
     * RequestTable constructor.
     *
     * @param TableGateway $tableGateway
     * @since 1.0.0
     */
    public function __construct(TableGateway $tableGateway) {
        parent::__construct($tableGateway);

        # Set Single Form Name
        $this->sSingleForm = 'contactrequest-single';
    }

    /**
     * Get Contact Entity
     *
     * @param int $id
     * @param string $sKey
     * @return mixed
     * @since 1.0.0
     */
     public function getSingle($id,$sKey = 'Request_ID') {
        # Use core function
        return $this->getSingleEntity($id,$sKey);
    }


    /**
     * Save Contact Entity
     *
     * @param Request $oRequest
     * @return int Request ID
     * @since 1.0.0
     */
    public function saveSingle(Request $oRequest) {
        $aDefaultData = [
            'label' => $oRequest->getLabel(),
        ];
        return $this->saveSingleEntity($oRequest,'Request_ID',$aDefaultData);
    }

    /**
     * Generate new single Entity
     *
     * @return Contact
     * @since 1.0.0
     */
    public function generateNew() {
        return new Request($this->oTableGateway->getAdapter());
    }
}