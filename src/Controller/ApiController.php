<?php
/**
 * ApiController.php - Contact Request Api Controller
 *
 * Main Controller for Contact Api
 *
 * @category Controller
 * @package Worktime
 * @author Verein onePlace
 * @copyright (C) 2020  Verein onePlace <admin@1plc.ch>
 * @license https://opensource.org/licenses/BSD-3-Clause
 * @version 1.0.0
 * @since 1.0.0
 */

declare(strict_types=1);

namespace OnePlace\Contact\Request\Controller;

use Application\Controller\CoreController;
use Application\Controller\CoreEntityController;
use Application\Model\CoreEntityModel;
use OnePlace\Contact\Request\Model\RequestTable;
use Laminas\View\Model\ViewModel;
use Laminas\Db\Adapter\AdapterInterface;
use Zend\I18n\Translator\Translator;

class ApiController extends CoreController {
    /**
     * Request Table Object
     *
     * @since 1.0.0
     */
    private $oTableGateway;

    /**
     * ApiController constructor.
     *
     * @param AdapterInterface $oDbAdapter
     * @param RequestTable $oTableGateway
     * @since 1.0.0
     */
    public function __construct(AdapterInterface $oDbAdapter,RequestTable $oTableGateway,$oServiceManager) {
        parent::__construct($oDbAdapter,$oTableGateway,$oServiceManager);
        $this->oTableGateway = $oTableGateway;
        $this->sSingleForm = 'contactrequest-single';
    }

    /**
     * Get a single Entity of Worktime
     *
     * @return bool - no View File
     * @since 1.0.0
     */
    public function indexAction() {
        $this->layout('layout/json');

        $aReturn = ['state'=>'success','message'=>'welcome to contact request api'];
        echo json_encode($aReturn);

        return false;
    }

        /**
     * Get a single Entity of Worktime
     *
     * @return bool - no View File
     * @since 1.0.0
     */
    public function elementorformAction() {
        $this->layout('layout/json');

        $aContactData = [];
        $aExtraFields = [];

        // test if form field exists
        if(array_key_exists('form',$_REQUEST)) {
            $aInfo = $_REQUEST;
            $aForm = $aInfo['form'];
            $aFields = $aInfo['fields'];
            $aMeta = $aInfo['meta'];
        } else {
            # Testdata for Postman
            $aContactData['email']='jb4@gmail.com';
            $aContactData['message']='TestMessage';
            $aContactData['name']='TestName Blabal';
            $aFields=[];
            # Display error message
//            $aReturn = ['state'=>'error','message'=>'no elementor form found'];
//            echo json_encode($aReturn);
//            return false;
        }


        if(count($aFields) > 0) {
            foreach($aFields as $aField) {
                switch($aField['id']) {
                    case 'event_date':
                        $aExtraFields['event_date'] = $aField['value'];
                        break;
                    case 'event_people':
                        $aExtraFields['event_people'] = $aField['value'];
                        break;
                    case 'name':
                        $aContactData['name'] = $aField['value'];
                        break;
                    case 'email':
                        $aContactData['email'] = $aField['value'];
                        break;
                    case 'message':
                        $aContactData['message'] = $aField['value'];
                        break;
                    default:
                        break;
                }
            }
        }

        // we need at least an email and a message to save a request
        if(array_key_exists('email',$aContactData)) {

            $oContactTbl = CoreController::$oServiceManager->get(\OnePlace\Contact\Model\ContactTable::class);
            $oAddressTbl = CoreController::$oServiceManager->get(\OnePlace\Contact\Address\Model\AddressTable::class);
            $oRequestTbl = CoreController::$oServiceManager->get(RequestTable::class);

            $oContactFound = $oContactTbl->fetchAll(false,['email_addr-like' => $aContactData['email']]);

            $oContact = false;
            if (count($oContactFound) > 0) {
                echo "found contact\n";
                $iContactID = $oContactFound->current()->getID();

            } else {
                echo "new contact\n";

                $sFirstname = '';
                $sLastname = '';
                $aName = explode(' ',$aContactData['name']);
                $sFirstname = $aName[0];
                if(isset($aName[1])) {
                    $sLastname = $aName[1];
                }

                /**
                 * Add Contact
                 */
                $oContact = $oContactTbl->generateNew();
                $oContact->exchangeArray([
                    'firstname' => $sFirstname,
                    'lastname' => $sLastname,
                    'description' => 'Automatisch erstellt vom Shop',
                    'email_addr' => $aContactData['email'],
                ]);
                $iContactID = $oContactTbl->saveSingle($oContact);

                /**
                 * Add Contact Address
                 */
                $oAddress = $oAddressTbl->generateNew();
                $oAddress->exchangeArray([
                    'contact_idfs' => $iContactID,
                    'country'=>'DE',
                ]);
                $oAddressTbl->saveSingle($oAddress);

            }

        }

        if(array_key_exists('message',$aContactData)) {
            echo "save request\n";

            $oTagNew = CoreEntityController::$aCoreTables['core-entity-tag']->select(['entity_form_idfs'=>'contactrequest-single','tag_value'=>'new']);
            $iTagNewID = 0;
            if(count($oTagNew) > 0) {
                $iTagNewID = $oTagNew->current()->Entitytag_ID;
            } else {
                echo "core-entity-tag new not found\n";
            }

            $oRequest = $oRequestTbl->generateNew();
            $oRequest->exchangeArray([
                'contact_idfs' => $iContactID,
                'state_idfs' => $iTagNewID,
                'message' => $aContactData['message'],
                'extra_fields' => json_encode($aExtraFields),
            ]);
            $oRequestTbl->saveSingle($oRequest);
        }

        $aFieldLabels = [
            'event_date'=>'Datum des Events',
            'event_people'=>'Anzahl Personen',
        ];

        //TODO: Email stuff
        //TODO: Settigs Layout
        /**
         * Get System Settings
         */
        //$aGlobalSettings = $this->viewRenderer->layout()->aSettings;

        $sExtraFields = '';
        if(count($aExtraFields) > 0) {
            foreach(array_keys($aExtraFields) as $sField) {
                $sFieldInfo = $aExtraFields[$sField];
                if(array_key_exists($sField,$aFieldLabels)) {
                    $sExtraFields .= htmlentities($aFieldLabels[$sField]).': '.htmlentities($sFieldInfo).'<br/>';
                } else {
                    $sExtraFields .= htmlentities($sField).': '.htmlentities($sFieldInfo).'<br/>';
                }
            }
        }

        // Produce HTML of password reset email
//        $bodyHtml = $this->viewRenderer->render(
//            'job/email/request',
//            [
//                'sContactName' => htmlentities($aContactData['name']),
//                'sContactEmail' => $aContactData['email'],
//                'sOrderComment' => htmlentities($aContactData['message']),
//                'sExtraInfo' => $sExtraFields,
//                'aMeta' => $aMeta,
//                'sInstallInfo' => $aGlobalSettings['noreply-footer-template'],
//                'sLogoPath'=>(file_exists($_SERVER['DOCUMENT_ROOT'].'/img/logo.svg')) ? 'https://'.$aGlobalSettings['system-url'].'/img/logo.svg' : 'https://'.$aGlobalSettings['system-url'].'/img/logo.png',
//            ]);
//
//        $html = new MimePart($bodyHtml);
//        $html->type = "text/html";
//
//        $body = new MimeMessage();
//        $body->addPart($html);
//
//        $mail = new Mail\Message();
//        $mail->setEncoding('UTF-8');
//        $mail->setBody($body);
//        $mail->setFrom( $aGlobalSettings['noreply-email'], $aGlobalSettings['noreply-from']);
//        $mail->addTo($aGlobalSettings['shop-admin-email'], 'Shop Admin');
//        $mail->setSubject($aGlobalSettings['shop-request-admin-subject']);


        file_put_contents($_SERVER['DOCUMENT_ROOT'].'/data/form-data.txt',print_r($oRequest,true));

        return false;
    }
}
