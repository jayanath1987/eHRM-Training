<?php

/**
 * OrangeHRM is a comprehensive Human Resource Management (HRM) System that captures
 * all the essential functionalities required for any enterprise.
 * Copyright (C) 2006 OrangeHRM Inc., http://www.orangehrm.com
 *
 * OrangeHRM is free software; you can redistribute it and/or modify it under the terms of
 * the GNU General Public License as published by the Free Software Foundation; either
 * version 2 of the License, or (at your option) any later version.
 *
 * OrangeHRM is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY;
 * without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 * See the GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License along with this program;
 * if not, write to the Free Software Foundation, Inc., 51 Franklin Street, Fifth Floor,
 * Boston, MA  02110-1301, USA
 */
/**
 * Actions class for Training module
 *
 * -------------------------------------------------------------------------------------------------------
 *  Author    - Jayanath Liyanage
 *  On (Date) - 17 June 2011
 *  Comments  - Employee main Training
 *  Version   - Version 1.0
 * -------------------------------------------------------------------------------------------------------
 * */
include ('../../lib/common/LocaleUtil.php');

class trainingActions extends sfActions {

    public function executeIndex(sfWebRequest $request) {
        
    }

    public function executeAjaxLock(sfWebRequest $request) {

        $encryption = new EncryptionHandler();
        if (!strlen($request->getParameter('lock'))) {
            $this->lockMode = 0;
        } else {
            $this->lockMode = $request->getParameter('lock');
        }
        $linsid = $encryption->decrypt($request->getParameter('insid'));
        $id = $encryption->decrypt($request->getParameter('id'));

        if (isset($this->lockMode)) {
            if ($this->lockMode == 1) {

                $conHandler = new ConcurrencyHandler();

                $recordLocked = $conHandler->setTableLock('hs_hr_td_assignlist', array($id, $linsid), 2);

                if ($recordLocked) {
                    $this->lockMode = 1;
                } else {

                    $this->lockMode = 0;
                }
            } else if ($this->lockMode == 0) {

                $conHandler = new ConcurrencyHandler();
                $recordLocked = $conHandler->setTableLock('hs_hr_td_assignlist', array($id, $linsid), 2);
                $this->lockMode = 0;
            }
            echo json_encode($this->lockMode);
            die;
        }
    }

    public function executeDefineinstitute(sfWebRequest $request) {


        try {
            $this->culture = $this->getUser()->getCulture();

            $instCourseService = new InstituteCourceService();
            $tSearchService=new TrainingSearchService();
            $this->instCourseService = $instCourseService;

            $this->sorter = new ListSorter('training.sort', 'td_module', $this->getUser(), array('td_inst_id', ListSorter::ASCENDING));

            $this->sorter->setSort(array($request->getParameter('sort'), $request->getParameter('order')));

//            if ($request->getParameter('mode') == 'search') {
//                if ($request->getParameter('searchMode') != 'all' && trim($request->getParameter('searchValue')) == '') {
//                    $this->setMessage('NOTICE', array('Select the field to search'));
//                    $this->redirect('training/defineinstitute');
//                }
//            }
            $this->searchMode = ($request->getParameter('searchMode') == '') ? 'all' : $request->getParameter('searchMode');
            $this->searchValue = ($request->getParameter('searchValue') == '') ? '' : $request->getParameter('searchValue');

            $this->sort = ($request->getParameter('sort') == '') ? 't.td_inst_id' : $request->getParameter('sort');
            $this->order = ($request->getParameter('order') == '') ? 'DESC' : $request->getParameter('order');

            $res = $tSearchService->searchinstitute($this->searchMode, $this->searchValue, $this->culture, $request->getParameter('page'), $this->sort, $this->order);
            $this->listinstitute = $res['data'];


            $this->pglay = $res['pglay'];
            $this->pglay->setTemplate('<a href="{%url}">{%page}</a>');
            $this->pglay->setSelectedTemplate('{%page}');
            if (count($res['data']) <= 0) {
                $this->setMessage('SUCCESS', array($this->getContext()->getI18N()->__("Sorry,Your Search did not Match any Records.", $args, 'messages')));
            }
            
        } catch (sfStopException $sf) {    
            
        } catch (Exception $e) {
            $errMsg = new CommonException($e->getMessage(), $e->getCode());
            $this->setMessage('WARNING', $errMsg->display());
            $this->redirect('default/error');
        }
    }

    public function executeSaveinstitute(sfWebRequest $request) {

        if ($request->isMethod('post')) {
 
            $instCourseService = new InstituteCourceService();
            $traningIns = new TrainingInstitute();

            try {
                (strlen($request->getParameter('txten')  ? $traningIns->setTd_inst_name_en(trim($request->getParameter('txten'))) : $traningIns->setTd_inst_name_en(null))); // returns true

                (strlen($request->getParameter('txtsi')  ? $traningIns->setTd_inst_name_si(trim($request->getParameter('txtsi'))) : $traningIns->setTd_inst_name_si(null))); // returns true

                (strlen($request->getParameter('txtta')  ? $traningIns->setTd_inst_name_ta(trim($request->getParameter('txtta'))) : $traningIns->setTd_inst_name_ta(null))); // returns true
                
            } catch (Exception $e) {
                $errMsg = new CommonException($e->getMessage(), $e->getCode());
                $this->setMessage('WARNING', $errMsg->display());

                $this->redirect('training/defineinstitute');
            }

            try {
                $instCourseService->saveTransIns($traningIns);
            } catch (Doctrine_Connection_Exception $e) {
                $errMsg = new CommonException($e->getPortableMessage(), $e->getPortableCode());
                $this->setMessage('WARNING', $errMsg->display());
                $this->redirect('training/defineinstitute');
            } catch (Exception $e) {
                $errMsg = new CommonException($e->getMessage(), $e->getCode());
                $this->setMessage('WARNING', $errMsg->display());
                $this->redirect('training/defineinstitute');
            }

            $this->lastid = $instCourseService->getLastInstituteID();

            $this->setMessage('SUCCESS', array($this->getContext()->getI18N()->__('Successfully Added', $args, 'messages')));
            $this->redirect('training/defineinstitute');
        }
    }

    public function executeUpdateinstitute(sfWebRequest $request) {
        $encrypt = new EncryptionHandler();
        try {
            $inId = $encrypt->decrypt($request->getParameter('id'));

            if (!strlen($encrypt->decrypt($request->getParameter('lock')))) {
                $this->lockMode = 0;
            } else {
                $this->lockMode = $encrypt->decrypt($request->getParameter('lock'));
            }


            if (isset($this->lockMode)) {
                if ($this->lockMode == 1) {

                    $conHandler = new ConcurrencyHandler();

                    $recordLocked = $conHandler->setTableLock('hs_hr_td_institute', array($inId), 1);

                    if ($recordLocked) {

                        $this->lockMode = 1;
                    } else {

                        $this->setMessage('WARNING', array($this->getContext()->getI18N()->__('Can not update. Record locked by another user.', $args, 'messages')), false);
                        $this->lockMode = 0;
                    }
                } else if ($this->lockMode == 0) {
                    $conHandler = new ConcurrencyHandler();
                    $recordLocked = $conHandler->resetTableLock('hs_hr_td_institute', array($inId), 1);
                    $this->lockMode = 0;
                }
            }
        } catch (Exception $e) {
            $errMsg = new CommonException($e->getMessage(), $e->getCode());
            $this->setMessage('WARNING', $errMsg->display());
            $this->redirect('training/defineinstitute');
        }





        $instCourseService = new InstituteCourceService();
        $traningIns = new TrainingInstitute();

        $transIns = $instCourseService->readTrainIns($encrypt->decrypt($request->getParameter('id')));
        if (!$transIns) {
            $this->setMessage('WARNING', array($this->getContext()->getI18N()->__('Can not update. Record has been Deleted', $args, 'messages')));
            $this->redirect('training/defineinstitute');
        }
        $this->transIns = $transIns;


        if ($request->isMethod('post')) {
            try {

                (strlen($request->getParameter('txten')  ? $transIns->setTd_inst_name_en(trim($request->getParameter('txten'))) : $transIns->setTd_inst_name_en(null))); // returns true

                (strlen($request->getParameter('txtsi')  ? $transIns->setTd_inst_name_si(trim($request->getParameter('txtsi'))) : $transIns->setTd_inst_name_si(null))); // returns true

                (strlen($request->getParameter('txtta')  ? $transIns->setTd_inst_name_ta(trim($request->getParameter('txtta'))) : $transIns->setTd_inst_name_ta(null))); // returns true

                
            } catch (Exception $e) {
                $errMsg = new CommonException($e->getMessage(), $e->getCode());
                $this->setMessage('WARNING', $errMsg->display());
                $this->redirect('training/defineinstitute');
            }
            try {

                $instCourseService->saveTransIns($transIns);
            } catch (Doctrine_Connection_Exception $e) {
                $errMsg = new CommonException($e->getPortableMessage(), $e->getPortableCode());
                $this->setMessage('WARNING', $errMsg->display());
                $this->redirect('training/defineinstitute');
            } catch (Exception $e) {
                $errMsg = new CommonException($e->getMessage(), $e->getCode());
                $this->setMessage('WARNING', $errMsg->display());
                $this->redirect('training/defineinstitute');
            }
            $this->lastid = $instCourseService->getLastInstituteID();
            $this->setMessage('SUCCESS', array($this->getContext()->getI18N()->__("Successfully Updated", $args, 'messages')));
            $this->redirect('training/Updateinstitute?id=' . $encrypt->encrypt($transIns->getTd_inst_id()) . '&lock=' . $encrypt->encrypt(0));
        }
    }

    public function executeDeleteinstitute(sfWebRequest $request) {


        if (count($request->getParameter('chkLocID')) > 0) {

            
            $trainingDeleteService=new DeleteTrainingService();
            try {
                $conn = Doctrine_Manager::getInstance()->connection();
                $conn->beginTransaction();
                $ids = array();
                $ids = $request->getParameter('chkLocID');

                $countArr = array();
                $saveArr = array();
                for ($i = 0; $i < count($ids); $i++) {
                    $conHandler = new ConcurrencyHandler();
                    $isRecordLocked = $conHandler->isTableLocked('hs_hr_td_institute', array($ids[$i]), 1);
                    if ($isRecordLocked) {
                        $countArr = $ids[$i];
                    } else {
                        $saveArr = $ids[$i];

                        $trainingDeleteService->deleteInstitute($ids[$i]);
                        $conHandler->resetTableLock('hs_hr_td_institute', array($ids[$i]), 1);
                    }
                }

                $conn->commit();
            } catch (Doctrine_Connection_Exception $e) {
                $errMsg = new CommonException($e->getPortableMessage(), $e->getPortableCode());
                $this->setMessage('WARNING', $errMsg->display());
                $this->redirect('training/defineinstitute');
            } catch (Exception $e) {
                $conn->rollBack();
                $errMsg = new CommonException($e->getMessage(), $e->getCode());
                $this->setMessage('WARNING', $errMsg->display());
                $this->redirect('training/defineinstitute');
            }
            if (count($saveArr) > 0 && count($countArr) == 0) {
                $this->setMessage('SUCCESS', array($this->getContext()->getI18N()->__("Successfully Deleted", $args, 'messages')));
            } elseif (count($saveArr) > 0 && count($countArr) > 0) {
                $this->setMessage('WARNING', array($this->getContext()->getI18N()->__("Some records are can not be deleted as them  Locked by another user ", $args, 'messages')));
            } elseif (count($saveArr) == 0 && count($countArr) > 0) {
                $this->setMessage('WARNING', array($this->getContext()->getI18N()->__("Can not delete as them  Locked by another user ", $args, 'messages')));
            }
        } else {
            $this->setMessage('NOTICE', array('Select at least one record to delete'));
        }
        $this->redirect('training/defineinstitute');
    }

    public function executeSaveCourse(sfWebRequest $request) {
        $this->culture = $this->getUser()->getCulture();
        $instCourseService = new InstituteCourceService();
        $this->institutelist = $instCourseService->getInstitutelist();
        $this->medium = $instCourseService->getmedium();
        $this->Level = $instCourseService->getLevelCombo();

        $this->isAdmin = $_SESSION['isAdmin'];
        if ($request->isMethod('post')) {


            try {
                $instCourseService->saveCourse($request);
            } catch (Doctrine_Connection_Exception $e) {
                $errMsg = new CommonException($e->getPortableMessage(), $e->getPortableCode());
                $this->setMessage('WARNING', $errMsg->display());
                $this->redirect('training/CourseList');
            } catch (Exception $e) {
                $errMsg = new CommonException($e->getMessage(), $e->getCode());
                $this->setMessage('WARNING', $errMsg->display());
                $this->redirect('training/CourseList');
            }

            $this->lastid = $instCourseService->getLastCourseID();

            $this->setMessage('SUCCESS', array($this->getContext()->getI18N()->__('Successfully Added', $args, 'messages')));
            $this->redirect('training/CourseList');
        }
    }

    public function executeUpdateCourse(sfWebRequest $request) {

        $encrypt = new EncryptionHandler();

        $this->culture = $this->getUser()->getCulture();
        $instCourseService = new InstituteCourceService();
        $course = new TrainingCourse();
        $this->isAdmin = $_SESSION['isAdmin'];
        $this->institutelist = $instCourseService->getInstitutelist();
        $this->medium = $instCourseService->getmedium();
        $currentCourseId = $encrypt->decrypt($request->getParameter('id'));


        $tcourse = $instCourseService->readCourse($encrypt->decrypt($request->getParameter('id')));

        if (!$tcourse) {
            $this->setMessage('WARNING', array($this->getContext()->getI18N()->__('Can not update. Record has been Deleted', $args, 'messages')));
            $this->redirect('training/CourseList');
        }
        $this->Level = $instCourseService->getLevelCombo();
        $this->tcourse = $tcourse;
        $fromtimerow = $tcourse->getTd_course_fromtime();
        $totimerow = $tcourse->getTd_course_totime();
        if($fromtimerow=="00:00:00" && $totimerow=="00:00:00"){
                $this->fromtimehrs = "";
                $this->fromtimemins = "";
                $this->totimehrs = "";
                $this->totimemins = "";
        }else{
        $fromtimeexpand = explode(':', $fromtimerow);
        $this->fromtimehrs = $fromtimeexpand[0];
        $this->fromtimemins = $fromtimeexpand[1];

        $totimeexpand = explode(':', $totimerow);
        $this->totimehrs = $totimeexpand[0];
        $this->totimemins = $totimeexpand[1];

        }
        

        try {

            if (!strlen($encrypt->decrypt($request->getParameter('lock')))) {
                $this->lockMode = 0;
            } else {
                $this->lockMode = $encrypt->decrypt($request->getParameter('lock'));
            }


            if (isset($this->lockMode)) {
                if ($this->lockMode == 1) {

                    $conHandler = new ConcurrencyHandler();


                    $recordLocked = $conHandler->setTableLock('hs_hr_td_course', array($currentCourseId), 1);

                    if ($recordLocked) {
                        // Display page in edit mode
                        $this->lockMode = 1;
                    } else {
                        $this->setMessage('WARNING', array($this->getContext()->getI18N()->__('Can not update. Record locked by another user.', $args, 'messages')), false);
                        $this->lockMode = 0;
                    }
                } else if ($this->lockMode == 0) {
                    $conHandler = new ConcurrencyHandler();

                    $recordLocked = $conHandler->resetTableLock('hs_hr_td_course', array($currentCourseId), 1);
                    $this->lockMode = 0;
                }
            }
        } catch (Exception $e) {
            $errMsg = new CommonException($e->getMessage(), $e->getCode());
            $this->setMessage('WARNING', $errMsg->display());
            $this->redirect('training/CourseList');
        }

        if ($request->isMethod('post')) {
            try {

                $tcourseDataObj=$instCourseService->updateCourceObject($request,$tcourse);

                
            } catch (Exception $e) {
                $errMsg = new CommonException($e->getMessage(), $e->getCode());
                $this->setMessage('WARNING', $errMsg->display());
                $this->redirect('training/CourseList');
            }
            try {
                $instCourseService->updateCourse($tcourseDataObj);
            } catch (sfStopException $esf) {
                
            } catch (Doctrine_Connection_Exception $e) {
                $errMsg = new CommonException($e->getPortableMessage(), $e->getPortableCode());
                $this->setMessage('WARNING', $errMsg->display());
                $this->redirect('training/CourseList');
            } catch (Exception $e) {
                $errMsg = new CommonException($e->getMessage(), $e->getCode());
                $this->setMessage('WARNING', $errMsg->display());
                $this->redirect('training/CourseList');
            }
            $this->setMessage('SUCCESS', array($this->getContext()->getI18N()->__("Successfully Updated", $args, 'messages')));
            $this->redirect('training/UpdateCourse?id=' . $request->getParameter('id') . '&lock=' . $encrypt->encrypt(0));
        }
    }

    public function executeCourseList(sfWebRequest $request) {

        try {
            $this->culture = $this->getUser()->getCulture();

            $instCourseService = new InstituteCourceService();
            $this->instCourseService = $instCourseService;
            $tSearchService=new TrainingSearchService();
            $this->sorter = new ListSorter('training.sort', 'td_module', $this->getUser(), array('td_inst_id', ListSorter::ASCENDING));

            $this->sorter->setSort(array($request->getParameter('sort'), $request->getParameter('order')));

//            if ($request->getParameter('mode') == 'search') {
//                if ($request->getParameter('searchMode') != 'all' && trim($request->getParameter('searchValue')) == '') {
//                    $this->setMessage('NOTICE', array('Select the field to search'));
//                    $this->redirect('training/defineinstitute');
//                }
//            }
            $this->searchMode = ($request->getParameter('searchMode') == '') ? 'all' : $request->getParameter('searchMode');
            $this->searchValue = ($request->getParameter('searchValue') == '') ? '' : $request->getParameter('searchValue');

            $this->sort = ($request->getParameter('sort') == '') ? 't.td_course_id' : $request->getParameter('sort');
            $this->order = ($request->getParameter('order') == '') ? 'DESC' : $request->getParameter('order');

            $res = $tSearchService->getCourseList($this->searchMode, $this->searchValue, $this->culture, $request->getParameter('page'), $this->sort, $this->order);
            $this->listCourse = $res['data'];


            $this->pglay = $res['pglay'];
            $this->pglay->setTemplate('<a href="{%url}">{%page}</a>');
            $this->pglay->setSelectedTemplate('{%page}');
            if (count($res['data']) <= 0) {
                $this->setMessage('SUCCESS', array($this->getContext()->getI18N()->__("Sorry,Your Search did not Match any Records.", $args, 'messages')));
            }
        } catch (Doctrine_Connection_Exception $e) {
                $errMsg = new CommonException($e->getPortableMessage(), $e->getPortableCode());
                $this->setMessage('WARNING', $errMsg->display());
                $this->redirect('default/error');    
        } catch (sfStopException $sf) {
            
        } catch (Exception $e) {
            $errMsg = new CommonException($e->getMessage(), $e->getCode());
            $this->setMessage('WARNING', $errMsg->display());
            $this->redirect('default/error');
        }
    }

    public function executeDeleteCourse(sfWebRequest $request) {


        if (count($request->getParameter('chkLocID')) > 0) {
            
            $trainingDeleteService=new DeleteTrainingService();
            try {
                $conn = Doctrine_Manager::getInstance()->connection();
                $conn->beginTransaction();
                $ids = array();
                $ids = $request->getParameter('chkLocID');
                $countArr = array();
                $saveArr = array();
                for ($i = 0; $i < count($ids); $i++) {
                    $conHandler = new ConcurrencyHandler();
                    $isRecordLocked = $conHandler->isTableLocked('hs_hr_td_course', array($ids[$i]), 1);
                    if ($isRecordLocked) {
                        $countArr = $ids[$i];
                    } else {
                        $saveArr = $ids[$i];
                        $trainingDeleteService->deleteCourse($ids[$i]);
                        $conHandler->resetTableLock('hs_hr_td_course', array($ids[$i]), 1);
                    }
                }

                $conn->commit();
            } catch (Doctrine_Connection_Exception $e) {
                $conn->rollBack();
                $errMsg = new CommonException($e->getPortableMessage(), $e->getPortableCode());
                $this->setMessage('WARNING', $errMsg->display());
                $this->redirect('training/CourseList');
            } catch (Exception $e) {
                $conn->rollBack();
                $errMsg = new CommonException($e->getMessage(), $e->getCode());
                $this->setMessage('WARNING', $errMsg->display());
                $this->redirect('default/error');
            }
            if (count($saveArr) > 0 && count($countArr) == 0) {
                $this->setMessage('SUCCESS', array($this->getContext()->getI18N()->__("Successfully Deleted", $args, 'messages')));
            } elseif (count($saveArr) > 0 && count($countArr) > 0) {
                $this->setMessage('WARNING', array($this->getContext()->getI18N()->__("Some records are can not be deleted as them  Locked by another user ", $args, 'messages')));
            } elseif (count($saveArr) == 0 && count($countArr) > 0) {
                $this->setMessage('WARNING', array($this->getContext()->getI18N()->__("Can not delete as them  Locked by another user ", $args, 'messages')));
            }
        } else {
            $this->setMessage('NOTICE', array('Select at least one record to delete'));
        }
        $this->redirect('training/CourseList');
    }

    public function executeParticipations(sfWebRequest $request) {
        $this->hideBtnFlag=$request->getParameter('hideBtnFlg');
        $instCourseService = new InstituteCourceService();
        $partiAssignService = new ParticipateAssignTrainService();
        $encrypt = new EncryptionHandler();
        if (!strlen($request->getParameter('lock'))) {

            $this->lockMode = 0;
        } else {
            $this->lockMode = $request->getParameter('lock');
        }

        $this->culture = $this->getUser()->getCulture();

        if (strlen($request->getParameter('mode'))) {
            $this->mode = $request->getParameter('mode');
        } else {
            $this->mode = 'edit';
        }
        $this->instList = $instCourseService->getInstitutelist();
        if (strlen($request->getParameter('id'))) {
            if (strlen($request->getParameter('mode'))) {
                $this->mode = $request->getParameter('mode');
            } else {
                $this->mode = 'save';
            }

            $courseID = $request->getParameter('id');

            $insid = $request->getParameter('insid');

            $this->instituteId = $insid;

            $this->cID = $request->getParameter('id');


            $this->GenerealComment = $partiAssignService->getGeneralComment($this->cID);



            $this->currentCourses = $partiAssignService->loadCourseList($insid);

            //assign list
            $courseList = $partiAssignService->getAllCourseList($request->getParameter('id'));
            $conHandler = new ConcurrencyHandler();

            if (!strlen($request->getParameter('lock'))) {

                $this->lockMode = 0;
            } else {
                $this->lockMode = $request->getParameter('lock');
            }
            $Empids = array();
            for ($i = 0; $i < count($courseList); $i++) {

                $Empids[] = $courseList[$i]->getEmp_Number();
            }

            if (isset($this->lockMode)) {
                if ($this->lockMode == 1) {


                    $numofRec = array();
                    for ($i = 0; $i < count($Empids); $i++) {

                        $numofRec[] = $Empids[$i];
                    }

                    $recordLocked2 = $conHandler->setTableLock('hs_hr_td_assignlist', array($courseID, $insid), 4);

                    if ($recordLocked2) {
                        $this->lockMode = 1;
                    } else {
                        $this->setMessage('WARNING', array($this->getContext()->getI18N()->__('Can not update. Record locked by another user.', $args, 'messages')), false);
                        $this->lockMode = 0;
                    }
                } else if ($this->lockMode == 0) {
                    $conHandler = new ConcurrencyHandler();
                    for ($i = 0; $i < count($Empids); $i++) {
                        
                    }
                    $recordLocked2 = $conHandler->resetTableLock('hs_hr_td_assignlist', array($courseID, $insid), 4);
                    $this->lockMode = 0;
                }
            }

            if ($this->lockMode == '1') {
                $editMode = false;
                $disabled = '';
            } else {
                $editMode = true;
                $disabled = 'disabled="disabled"';
            }



            $this->assCourse = $courseList;

            $this->i = 0;
            $this->childDiv = "";
            foreach ($courseList as $list) {
                if ($list->getTd_asl_isapproved() != -1) {
                    $isLocked = $conHandler->isTableLocked('hs_hr_td_assignlist', array($list->getEmp_number(), $courseID), 4);


                    $this->i = $this->i + 1;

                    $yes=($list->getTd_asl_isattend() == 1 ? "selected" : "");
                    $no=($list->getTd_asl_isattend() == 0 ? "selected" : "");
                    $apped=($list->getTd_asl_isapproved() == 'Yes' ? "selected" : "");
                    
                    if ($list->getTd_asl_isapproved() == 'No')
                        $noapped = "selected";
                    elseif ($list->getTd_asl_isapproved() == 0)
                        $noapped = "";



                    if ($list->getTd_asl_isapproved() == 0) {
                        $status = $this->getContext()->getI18N()->__('Pending', $args, 'messages');
                    } elseif ($list->getTd_asl_isapproved() == -1) {
                        $status = $this->getContext()->getI18N()->__('No', $args, 'messages');
                    } elseif ($list->getTd_asl_isapproved() == 1) {
                        $status = $this->getContext()->getI18N()->__('Yes', $args, 'messages');
                    }

                    $wlangYes = $this->getContext()->getI18N()->__('Yes', $args, 'messages');
                    $wlangNo = $this->getContext()->getI18N()->__('No', $args, 'messages');

                    $this->childDiv.="<div id='row_" . $this->i . "' style='padding-top:15px;  height:100%; display:inline-block;'>";
                    $this->childDiv.="<div class='centerCol' id='master' style='width:150px;'>";
                    if ($isLocked) {
                        $lk = $this->getContext()->getI18N()->__('Record Locked', $args, 'messages');
                    } else {
                        $lk = "";
                    }
                    if (!$isLocked && $this->lockMode == '1') {

                        $hidedelete = $this->getContext()->getI18N()->__('Remove', $args, 'messages');
                        $history = $this->getContext()->getI18N()->__('Training History', $args, 'messages');
                        $disabled = "";
                    } else {
                        $hidedelete = "";
                        $history = "";
                        $disabled = "disabled";
                    }
                    if ($this->culture == "en") {
                        $abc = "emp_display_name";
                        $empName = $list->Employee->emp_display_name;
                    } else {
                        $abc = "emp_display_name_" . $this->culture;
                        if ($list->Employee->$abc == "") {


                            $empName = $list->Employee->emp_display_name;
                        } else {
                            $empName = $list->Employee->$abc;
                        }
                    }
                    $this->childDiv.="<div id='child' style=' padding-left:3px;'>" . $empName . "</div>";
                    $this->childDiv.="</div>";
                    $this->childDiv.="<div class='centerCol' id='master' style='width:100px;'>";
                    if ($list->getTd_asl_isapproved() == 0 || $list->getTd_asl_isapproved() == -1) {
                        $this->childDiv.="<div id='child' style=' padding-left:3px;'><select id='parti' name='parti_" . $courseID . "_" . $list->getEmp_number() . "_" . $this->i . "' style='width:50px;' ><option id='0' value='0' " . $no . ">$wlangNo</option></select></div>";
                    } else if ($list->getTd_asl_isapproved() == 1) {
                        $this->childDiv.="<div id='child' style=' padding-left:3px;'><select id='parti' name='parti_" . $courseID . "_" . $list->getEmp_number() . "_" . $this->i . "' style='width:50px;' ><option id='1' value='1' " . $yes . ">$wlangYes</option><option id='0' value='0' " . $no . ">$wlangNo</option></select></div>";
                    }
                    $this->childDiv.="</div>";
                    $this->childDiv.="<div class='centerCol' id='master' style='width:100px;'>";
                    $this->childDiv.="<div id='child' style=' padding-left:3px;'><input type='text' style='width:50px;' readonly='readonly' name='appro_" . $courseID . "_" . $list->getEmp_number() . "_" . $this->i . "' value='" . $status . "'/></div>";
                    $this->childDiv.="</div>";
                    $this->childDiv.="<div class='centerCol' id='master' style='width:150px;'>";
                    $this->childDiv.="<div id='child'  style=' padding-right:10px;'><input type='text' maxlength='200' onkeypress='return onkeyUpevent(event)' onblur='return validationComment(event,this.id)'  id='commentgrid_" . $courseID . "_" . $list->getEmp_number() . "_" . $this->i . "' name='commentgrid_" . $courseID . "_" . $list->getEmp_number() . "_" . $this->i . "' style='width:125px;' value= '" . $list->getTd_asl_comment() . "' /></div>";
                    $this->childDiv.="</div>";
                    $this->childDiv.="<div class='centerCol' id='master' style='width:100px;'>";
                    $ecn = $encrypt->encrypt($list->getEmp_number());
                    $this->childDiv.="<div id='child' style=' padding-right:0px;'><a href='#' style='width:50px;' onclick='trainingHistoryPopup(\"{$ecn}\");'>" . $history . "</a>" . $lk . "</div>";
                    $this->childDiv.="</div>";
                    $this->childDiv.="<div class='centerCol' id='master' style='width:85px;'>";
                    //$this->childDiv.="<div id='child' style='height:25px; padding-left:0px;'><a href='#' class='deleteLinks' style='width:50px;' onclick='deleteSaved(" . $list->getEmp_number() . "," . $this->cID . "," . $this->i . "," . $this->instituteId . ");'>" . $hidedelete . "</a>" . $lk . "</div>";
                    $this->childDiv.="</div>";
                    $this->childDiv.="</div>";
                }
            }
        }

        if ($request->isMethod('post')) {



            $partiAssignService->UpdateCommentAssign($request->getParameter('courseid'), $request->getParameter('gencomment_en'), $this->culture);


            array_slice($_POST, 0, 3);

            $without_3 = array_slice($_POST, 3);

             array_pop($without_3);
             array_pop($without_3);

            $sult = array();

            foreach ($without_3 as $key => $value) {

                $rest = explode("_", $key);



                $arrname = 'a_' . $rest[3];

                if (!is_array($$arrname)) {
                    $$arrname = Array();
                    $sult[] = $rest[3];
                }
                ${$arrname}[$key] = $value;
            }


            $conn = Doctrine_Manager::getInstance()->connection();
            $conn->beginTransaction();
            try {

                for ($i = 0; $i < count($sult); $i++) {


                    $abc = 'a_' . $sult[$i];


                    $avalues = array_values($$abc);

                    $keys = array_keys($$abc);
                    $isthere = $keys[0];


                    $exlopdearray = explode('_', $isthere);
                    $courseID = $exlopdearray[1];

                    $employeeID = $exlopdearray[2];

                    $exist = $partiAssignService->checkAssignedcourse($courseID, $employeeID);

                    if (!strlen($exist[0]['emp_number'])) {


                        $trainassign = new TrainAssign();
                        $trainassign->setEmp_number($employeeID);
                        $trainassign->setTd_course_id($courseID);
                        $trainassign->setTd_asl_isattend($avalues[0]);

                        $trainassign->setTd_asl_isapproved('0');
                        $trainassign->setTd_asl_ispending('0');
                        $trainassign->setTd_asl_year($_POST['txtyear']);
                        $trainassign->setTd_asl_comment($avalues[2]);
                        $trainassign->setTd_asl_admincomment($_POST['gencomment_en']);

                        $saved = $partiAssignService->saveAssignList($trainassign);
                    } else {

                        $updated = $partiAssignService->updateAssignListParticipate($employeeID, $courseID, $avalues[0], $avalues[2], $_POST['txtyear'], $_POST['gencomment_en']);
                    }
                }
                $conn->commit();
            } catch (Doctrine_Connection_Exception $e) {
                $conn->rollBack();
                $errMsg = new CommonException($e->getPortableMessage(), $e->getPortableCode());
                $this->setMessage('WARNING', $errMsg->display());
                $this->redirect('training/participations?lock=1&hideBtnFlg=1');
            } catch (Exception $e) {
                $conn->rollBack();
                $errMsg = new CommonException($e->getMessage(), $e->getCode());
                $this->setMessage('WARNING', $errMsg->display());

                $this->redirect('training/participations?lock=1&hideBtnFlg=1');
            }

            if (isset($saved)) {
                $this->setMessage('NOTICE', array($this->getContext()->getI18N()->__('Successfully saved', $args, 'messages')));

                $this->redirect('training/participations?id=' . $courseID . '&insid=' . $insid . '&hideBtnFlg=1&mode=edit');
            }
            if (isset($updated)) {
                $this->setMessage('SUCCESS', array($this->getContext()->getI18N()->__('Successfully Updated', $args, 'messages')));

                $this->redirect('training/participations?id=' . $courseID . '&insid=' . $insid . '&hideBtnFlg=1&mode=edit');
            }
        }
    }

    public function executeAssigntrain(sfWebRequest $request) {
        
        $SempNum = $_SESSION['isAdmin'];

         if ($SempNum == "Yes") {
            $this->setMessage('WARNING', array($this->getContext()->getI18N()->__("Admin Can not assign employee(s) to training.", $args, 'messages')));
            $this->redirect('default/error');
        }
        
        
        try {
            $this->hideBtnFlag=$request->getParameter('hideBtnFlg');
            $this->editMode == 0;
            $partiAssignService = new ParticipateAssignTrainService();

            $wfDao = new workflowDao();

            $encrypt = new EncryptionHandler();

            $instCourseService = new InstituteCourceService();

            if (!strlen($encrypt->decrypt($request->getParameter('lock')))) {
                $this->lockMode = 0;
            } else {
                $this->lockMode = $encrypt->decrypt($request->getParameter('lock'));
            }

            $this->culture = $this->getUser()->getCulture();

            if (strlen($request->getParameter('mode'))) {
                $this->mode = $request->getParameter('mode');
            } else {
                $this->mode = 'edit';
            }
            $this->instList = $instCourseService->getInstitutelist();
            if (strlen($encrypt->decrypt($request->getParameter('id')))) {
                if (strlen($request->getParameter('mode'))) {
                    $this->mode = $request->getParameter('mode');
                } else {
                    $this->mode = 'save';
                }

                $courseID = $encrypt->decrypt($request->getParameter('id'));

                $insid = $encrypt->decrypt($request->getParameter('insid'));

                $this->instituteId = $insid;

                $this->cID = $encrypt->decrypt($request->getParameter('id'));
                $this->GenerealComment = $partiAssignService->getGeneralComment($this->cID);



                $this->currentCourses = $partiAssignService->loadCourseList($insid);


                $courseList = $partiAssignService->getAllCourseList($encrypt->decrypt($request->getParameter('id')));
                $conHandler = new ConcurrencyHandler();

                if (!strlen($encrypt->decrypt($request->getParameter('lock')))) {

                    $this->lockMode = 0;
                } else {
                    $this->lockMode = $encrypt->decrypt($request->getParameter('lock'));
                }
                $Empids = array();
                for ($i = 0; $i < count($courseList); $i++) {

                    $Empids[] = $courseList[$i]->getEmp_Number();
                }

                if (isset($this->lockMode)) {
                    if ($this->lockMode == 1) {


                        $numofRec = array();
                        for ($i = 0; $i < count($Empids); $i++) {


                            $numofRec[] = $Empids[$i];
                        }
                        $recordLocked2 = $conHandler->setTableLock('hs_hr_td_assignlist', array($courseID, $insid), 2);


                        if ($recordLocked2) {
                            $this->lockMode = 1;
                        } else {
                            $this->setMessage('WARNING', array($this->getContext()->getI18N()->__('Can not update. Record locked by another user.', $args, 'messages')), false);
                            $this->lockMode = 0;
                        }
                    } else if ($this->lockMode == 0) {

                        $conHandler = new ConcurrencyHandler();
                        for ($i = 0; $i < count($Empids); $i++) {
                            
                        }
                        $recordLocked2 = $conHandler->resetTableLock('hs_hr_td_assignlist', array($courseID, $insid), 2);
                        $this->lockMode = 0;
                    }
                }

                if ($this->lockMode == '1') {
                    $editMode = false;
                    $disabled = '';
                } else {
                    $editMode = true;
                    $disabled = 'disabled="disabled"';
                }


                //get the distnict of training year
                $this->trainingYears = $partiAssignService->getDistinctTrainYear();

                $this->assCourse = $courseList;


                $this->i = 0;
                $this->childDiv = "";
                foreach ($courseList as $list) {
                    $isLocked = $conHandler->isTableLocked('hs_hr_td_assignlist', array($list->getEmp_number(), $courseID), 2);


                    $this->i = $this->i + 1;

                    $yes=($list->getTd_asl_isattend() == 1 ? "selected" : "");
                    $no=($list->getTd_asl_isattend() == 0 ? "selected" : "");
                    $apped=($list->getTd_asl_isapproved() == 'Yes' ? "selected" : "");

                
                    if ($list->getTd_asl_isapproved() == 'No')
                        $noapped = "selected";
                    elseif ($list->getTd_asl_isapproved() == 0)
                        $noapped = "";



                    if ($list->getTd_asl_ispending() == 0) {
                        $status = $this->getContext()->getI18N()->__('Pending', $args, 'messages');
                    } elseif ($list->getTd_asl_isapproved() == 0) {
                        $status = $this->getContext()->getI18N()->__('No', $args, 'messages');
                    } elseif ($list->getTd_asl_isapproved() == 1) {
                        $status = $this->getContext()->getI18N()->__('Yes', $args, 'messages');
                    }

                    $wlangYes = $this->getContext()->getI18N()->__('Yes', $args, 'messages');
                    $wlangNo = $this->getContext()->getI18N()->__('No', $args, 'messages');

                    $this->childDiv.="<div id='row_" . $this->i . "' style='padding-top:15px;  height:100%; display:inline-block;'>";
                    $this->childDiv.="<div class='centerCol' id='master' style='width:150px;'>";
                    if ($isLocked) {
                        $lk = $this->getContext()->getI18N()->__('Record Locked', $args, 'messages');
                    } else {
                        $lk = "";
                    }
                    if (!$isLocked && $this->lockMode == '1') {

                        $hidedelete = $this->getContext()->getI18N()->__('Remove', $args, 'messages');
                        $history = $this->getContext()->getI18N()->__('Training History', $args, 'messages');
                        $disabled = "";
                    } else {
                        $hidedelete = "";
                        $history = "";
                        $disabled = "disabled";
                    }
                    if ($this->culture == "en") {
                        $abc = "emp_display_name";
                        $empName = $list->Employee->emp_display_name;
                    } else {

                        $abc = "emp_display_name_" . $this->culture;
                        if ($list->Employee->$abc == "") {


                            $empName = $list->Employee->emp_display_name;
                        } else {
                            $empName = $list->Employee->$abc;
                        }
                    }

                    $this->childDiv.="<div id='child' style='height:auto; padding-left:3px;'>" . $empName . "</div>";
                    $this->childDiv.="</div>";

                    $this->childDiv.="<div class='centerCol' id='master' style='width:270px;'>";
                    $this->childDiv.="<div id='child'  style='height:25px; padding-left:3px;'><input style='width:220px;' type='text' maxlength='200' onkeypress='return onkeyUpevent(event)' onblur='return validationComment(event,this.id)' " . $disabled . " id='commentgrid_" . $courseID . "_" . $list->getEmp_number() . "_" . $this->i . "' name='commentgrid_" . $courseID . "_" . $list->getEmp_number() . "_" . $this->i . "' style='width:125px;' value='" . $list->getTd_asl_comment() . "' ></div>";
                    $this->childDiv.="</div>";

                    $this->childDiv.="<div class='centerCol' id='master' style='width:108px;'>";

                    $this->childDiv.="<div id='child' style='height:25px; padding-right:8px;'><a href='#' style='width:50px;' onclick='trainingHistoryPopup(" . $list->getEmp_number() . ");'>" . $history . "</a>" . $lk . "</div>";
                    $this->childDiv.="</div>";
                    $this->childDiv.="<div class='centerCol' id='master' style='width:100px;'>";

                    $this->childDiv.="<div id='child' style='height:25px; padding-left:3px;'><a href='#' class='deleteLinks' style='width:50px;' onclick='deleteSaved(" . $list->getEmp_number() . "," . $this->cID . "," . $this->i . "," . $this->instituteId . ");'>" . $hidedelete . "</a>" . $lk . "</div>";
                    $this->childDiv.="</div>";
                    $this->childDiv.="</div>";
                }
            }
        } catch (sfStopException $sfstop) {
            
        } catch (Doctrine_Connection_Exception $e) {
            $errMsg = new CommonException($e->getPortableMessage(), $e->getPortableCode());
            $this->setMessage('WARNING', $errMsg->display());
            $this->redirect('training/assigntrain?id=' . $encrypt->encrypt($courseID) . '&insid=' . $encrypt->encrypt($insid) . '&lock=' . $encrypt->encrypt(0));
        } catch (Exception $e) {

            $errMsg = new CommonException($e->getMessage(), $e->getCode());
            $this->setMessage('WARNING', $errMsg->display());

            $this->redirect('training/assigntrain?id=' . $encrypt->encrypt($courseID) . '&insid=' . $encrypt->encrypt($insid) . '&lock=' . $encrypt->encrypt(0));
        }


        if ($request->isMethod('post')) {

            

            


             array_slice($_POST, 0, 3);

            $without_3 = array_slice($_POST, 3);



           array_pop($without_3);
            array_pop($without_3);




            $sult = array();

            foreach ($without_3 as $key => $value) {


                $rest = explode("_", $key);

                $arrname = 'a_' . $rest[3];


                if (!is_array($$arrname)) {
                    $$arrname = Array();
                    $sult[] = $rest[3];
                }
                ${$arrname}[$key] = $value;
            }

            //beging transactions
            $conn = Doctrine_Manager::getInstance()->connection();
            $conn->beginTransaction();
            try {

                for ($i = 0; $i < count($sult); $i++) {


                    $abc = 'a_' . $sult[$i];


                    $avalues = array_values($$abc);

                    $keys = array_keys($$abc);
                    $isthere = $keys[0];


                    $exlopdearray = explode('_', $isthere);
                    $courseID = $exlopdearray[1];

                    $employeeID = $exlopdearray[2];

                    $exist = $partiAssignService->checkAssignedcourse($courseID, $employeeID);


                    if (!strlen($exist[0]['emp_number'])) {


                        $trainassign = new TrainAssign();
                        $trainassign->setEmp_number($employeeID);
                        $trainassign->setTd_course_id($courseID);
                        $trainassign->setTd_asl_isattend('0');

                        $trainassign->setTd_asl_isapproved('0');
                        //$trainassign->setTd_asl_isapproved('0');
                        $trainassign->setTd_asl_ispending('0');
                        $trainassign->setTd_asl_year($_POST['txtyear']);

                        $trainassign->setTd_asl_comment($avalues[0]);
                        
                        $sysConf = OrangeConfig::getInstance()->getSysConf();
                        
                        $Supervisor=$instCourseService->readEmployeeSupervisor($employeeID);
                        $couse=$instCourseService->getCoursename($courseID);
                        //die(print_r($couse->td_approval_type));  
                        if($Supervisor->supervisorId != null){
                          
                         $TRNPOS1=  $sysConf->TRNPOS1; 
                        $trainassign->setApp_emp_number($Supervisor->supervisorId);
                        $trainassign->setApp_position($TRNPOS1);
                        $trainassign->setTd_approval_type($couse->td_approval_type);
                        }else{
                            $this->setMessage('WARNING', array($this->getContext()->getI18N()->__("Please assign a supervisor.", $args, 'messages')));
                            $this->redirect('training/assigntrain');
                        }
                        //$trainassign->setTd_asl_admincomment($_POST['gencomment_en']);

                        $roleAdmin = 6;
                        $roleSect = 12;

                        $HeadDiv = $partiAssignService->getDivHeadorApprover($employeeID);


                        //$sysConf = OrangeConfig::getInstance()->getSysConf();
                        $hie_code = $sysConf->hie_code;
                        $Headoffice = $sysConf->Headoffice;
                        $DivisionSecretory = $sysConf->DivisionSecretory;
                        $DistrictSecretory = $sysConf->DistrictSecretory;
                        $HRTeam = $sysConf->HRTeam;
                        $HRAdmin = $sysConf->HRAdmin;

                        $empDeatils = $partiAssignService->LoadEmployeeDetails($employeeID);

                        $employee = $_SESSION['empNumber'];
                        // WorkFlow
                        /*
                        $HRAdmin = $partiAssignService->getCompanyStructureDetailRole($employee, $HRAdmin);
                        if ($HRAdmin->CompanyStructure->def_level != null) {//die("HRAdminApproved");
                            $trainassign->setTd_asl_status('5');
                            $trainassign->setTd_asl_isapproved('1');
                             $returnWF[0]="app";

                        } else {
                            $HRTeam = $partiAssignService->getCompanyStructureDetailRole($employee, $HRTeam);

                            if ($HRTeam->CompanyStructure->def_level != null) {//die("HRAdmin");
                                $trainassign->setTd_asl_status('4');
                                //die($employeeID);
                                $returnWF = $wfDao->startWorkFlow(6, $employee);
                            } else {
                                $LoginEmpDeatilsDistrict = $partiAssignService->getCompanyStructureDetailRole($employee, $DistrictSecretory);
                                if ($LoginEmpDeatilsDistrict->CompanyStructure->def_level != null) {
                                    $Dishiecode = "hie_code_" . $LoginEmpDeatilsDistrict->CompanyStructure->def_level;
                                } else {
                                    $Dishiecode = "hie_code_1";
                                }
                                    
                                if ($empDeatils->$Dishiecode == $LoginEmpDeatilsDistrict->CompanyStructure->id) {//die("DisSec");
                                    $returnWF = $wfDao->startWorkFlow(4, $employee);
                                    $trainassign->setTd_asl_status('2');
                                } else {

                                    $LoginEmpDeatils = $partiAssignService->getCompanyStructureDetailRole($employee, $DivisionSecretory);
                                    if ($LoginEmpDeatils->CompanyStructure->def_level != null) {
                                        $Divhiecode = "hie_code_" . $LoginEmpDeatils->CompanyStructure->def_level;
                                    } else {
                                        $Divhiecode = "hie_code_1";
                                    }
                                    $Divhiecode = $Divhiecode;
                                    if ($empDeatils->$Divhiecode == $LoginEmpDeatils->CompanyStructure->id) {//die("HRTeam");
                                        $returnWF = $wfDao->startWorkFlow(5, $employee);
                                        $trainassign->setTd_asl_status('3');
                                    } else {
                                        



                                        if ($empDeatils->$hie_code == $Headoffice) {//die("HRTeam2");
                                            $returnWF = $wfDao->startWorkFlow(5, $employee);
                                            $trainassign->setTd_asl_status('3');
                                            $trainassign->setWfmain_id($returnWF[0]);
                                            $trainassign->setWfmain_sequence(1);
                                        } else {
                                            if ($HeadDiv[0]['CompanyStructure'][0]['def_level'] > ($sysConf->DivisionLevel - 1)) {//die("DivSec1");
                                                
                                                $returnWF = $wfDao->startWorkFlow(3, $employee);
                                                
                                                $trainassign->setTd_asl_status('1');
                                            } else if ($HeadDiv[0]['CompanyStructure'][0]['def_level'] > ($sysConf->DistrictLevel - 1)) {//die("DisSec1");
                                               
                                                $returnWF = $wfDao->startWorkFlow(4, $employee);
                                                $trainassign->setTd_asl_status('2');
                                               
                                            } else if ($HeadDiv[0]['CompanyStructure'][0]['def_level'] > 2) {//die("HRTeam1");
                                                $returnWF = $wfDao->startWorkFlow(5, $employee);
                                                $trainassign->setTd_asl_status('3');
                                            } else if ($HeadDiv[0]['CompanyStructure'][0]['def_level'] > 1) {//die("HRAdmin1");
                                                $returnWF = $wfDao->startWorkFlow(5, $employee);
                                                $trainassign->setTd_asl_status('4');
                                            }
                                        }
                                    }
                                }
                            }
                        } 
                        if ($returnWF == null || $returnWF[0] == "-1") {

                            throw new CommonException(null, 105);
                        } else {
                            if($returnWF[0]=="app"){
                            $trainassign->setWfmain_id(null);
                            $trainassign->setWfmain_sequence(null);
                            }else{
                            $trainassign->setWfmain_id($returnWF[0]);
                            $trainassign->setWfmain_sequence(1);
                            }
                        }
                         */
                        //---

                        $saved = $partiAssignService->saveAssignList($trainassign);
                    } else {

                        $updated = $partiAssignService->updateAssignList($employeeID, $courseID, '0', $avalues, $_POST['txtyear'], $_POST['gencomment_en']);
                    }
                }
                $conn->commit();
            } catch (sfStopException $sfstop) {
            }
             catch (Doctrine_Connection_Exception $e) {
                $conn->rollBack();
                $errMsg = new CommonException($e->getPortableMessage(), $e->getPortableCode());
                $this->setMessage('WARNING', $errMsg->display());
                $this->redirect('training/assigntrain?id=' . $encrypt->encrypt($courseID) . '&insid=' . $encrypt->encrypt($insid) . '&hideBtnFlg=1&lock=' . $encrypt->encrypt(0));
            }
             catch (Exception $e) {
                $conn->rollBack();
                $errMsg = new CommonException($e->getMessage(), $e->getCode());
                $this->setMessage('WARNING', $errMsg->display());

                $this->redirect('training/assigntrain?id=' . $encrypt->encrypt($courseID) . '&insid=' . $encrypt->encrypt($insid) . '&hideBtnFlg=1&lock=' . $encrypt->encrypt(0));
            }

            if (isset($saved)) {
                $this->setMessage('SUCCESS', array($this->getContext()->getI18N()->__('Successfully Saved', $args, 'messages')));

                $this->redirect('training/assigntrain?id=' . $encrypt->encrypt($courseID) . '&insid=' . $encrypt->encrypt($insid) . '&hideBtnFlg=1&lock=' . $encrypt->encrypt(0));
            }
            if (isset($updated)) {
                $this->setMessage('SUCCESS', array($this->getContext()->getI18N()->__('Successfully Updated', $args, 'messages')));

                $this->redirect('training/assigntrain?id=' . $encrypt->encrypt($courseID) . '&insid=' . $encrypt->encrypt($insid) . '&hideBtnFlg=1&lock=' . $encrypt->encrypt(0));
            }
        }

    }

    public function executeTrainingHistory(sfWebRequest $request) {
        $encrypt = new EncryptionHandler();
        $this->emp = $encrypt->decrypt($request->getParameter('empId'));
        $empId = $encrypt->decrypt($request->getParameter('empId'));

        if ($request->getParameter('empId')) {
            if (strlen($empId)) {
                $_SESSION['empTrainsummery'] = $empId;
            }
        } else {
            $_SESSION['empTrainsummery'] = $_SESSION['empNumber'];
        }

        try {

            $this->culture = $this->getUser()->getCulture();
            $this->isAdmin = $_SESSION['isAdmin'];
            $this->empId = $_SESSION['empNumber'];

            $partiAssignService = new ParticipateAssignTrainService();
            $this->partiAssignService = $partiAssignService;
            $tSearchService=new TrainingSearchService();
            $this->sorter = new ListSorter('trainHistory.sort', 'TandD_module', $this->getUser(), array('lastName', ListSorter::ASCENDING));

            $this->sorter->setSort(array($request->getParameter('sort'), $request->getParameter('order')));

//            if ($request->getParameter('mode') == 'search') {
//                if ($request->getParameter('searchMode') != 'all' && trim($request->getParameter('searchValue')) == '') {
//                    $this->setMessage('NOTICE', array('Select the field to search'));
//                    $this->redirect('training/trainingHistory');
//                }
//            }
            $this->searchMode = ($request->getParameter('searchMode') == '') ? 'all' : $request->getParameter('searchMode');
            $this->searchValue = ($request->getParameter('searchValue') == '') ? '' : $request->getParameter('searchValue');

            $this->sort = ($request->getParameter('sort') == '') ? 't.td_course_id' : $request->getParameter('sort');
            $this->order = ($request->getParameter('order') == '') ? 'ASC' : $request->getParameter('order');

            $res = $tSearchService->searchEmployeeTrainHistory($this->searchMode, $this->searchValue, $this->culture, $request->getParameter('page'), $this->sort, $this->order, $this->empId);
            $this->trainSummeryList = $res['data'];
            $this->pglay = $res['pglay'];
            $this->pglay->setTemplate('<a href="{%url}">{%page}</a>');
            $this->pglay->setSelectedTemplate('{%page}');
            if (count($res['data']) <= 0) {
                $this->setMessage('SUCCESS', array($this->getContext()->getI18N()->__("Sorry,Your Search did not Match any Records.", $args, 'messages')));
            }
        } catch (sfStopException $e) {
            
        } catch (Doctrine_Connection_Exception $e) {

            $errMsg = new CommonException($e->getPortableMessage(), $e->getPortableCode());
            $this->setMessage('WARNING', $errMsg->display());
            $this->redirect('training/trainingHistory');
        } catch (Exception $e) {

            $errMsg = new CommonException($e->getMessage(), $e->getCode());
            $this->setMessage('WARNING', $errMsg->display());

            $this->redirect('training/trainingHistory');
        }
    }

    public function executeTrainsummery(sfWebRequest $request) {

        try {

            $this->culture = $this->getUser()->getCulture();
            $this->isAdmin = $_SESSION['isAdmin'];

            $this->empId = $_SESSION['empNumber'];

            $partiAssignService = new ParticipateAssignTrainService();
            $this->partiAssignService = $partiAssignService;
             $tSearchService=new TrainingSearchService();
            $this->sorter = new ListSorter('trainsummery.sort', 'TandD_module', $this->getUser(), array('lastName', ListSorter::ASCENDING));

            $this->sorter->setSort(array($request->getParameter('sort'), $request->getParameter('order')));

//            if ($request->getParameter('mode') == 'search') {
//                if ($request->getParameter('searchMode') != 'all' && trim($request->getParameter('searchValue')) == '') {
//                    $this->setMessage('NOTICE', array('Select the field to search'));
//                    $this->redirect('training/Trainsummery');
//                }
//            }
            $this->searchMode = ($request->getParameter('searchMode') == '') ? 'all' : $request->getParameter('searchMode');
            $this->searchValue = ($request->getParameter('searchValue') == '') ? '' : $request->getParameter('searchValue');

            $this->sort = ($request->getParameter('sort') == '') ? 't.td_course_id' : $request->getParameter('sort');
            $this->order = ($request->getParameter('order') == '') ? 'ASC' : $request->getParameter('order');

            $res = $tSearchService->searchEmployeeTrain($this->searchMode, $this->searchValue, $this->culture, $request->getParameter('page'), $this->sort, $this->order);
            $this->trainSummeryList = $res['data'];
            $this->pglay = $res['pglay'];
            $this->pglay->setTemplate('<a href="{%url}">{%page}</a>');
            $this->pglay->setSelectedTemplate('{%page}');
            if (count($res['data']) <= 0) {
                $this->setMessage('SUCCESS', array($this->getContext()->getI18N()->__("Sorry,Your Search did not Match any Records.", $args, 'messages')));
            }
            
        } catch (sfStopException $sf) {
            
        } catch (Exception $e) {

            $errMsg = new CommonException($e->getMessage(), $e->getCode());
            $this->setMessage('WARNING', $errMsg->display());

            $this->redirect('default/error');
        }
    }

    public function executeParticipateSummery(sfWebRequest $request) {
        try {

            $this->culture = $this->getUser()->getCulture();
            $this->isAdmin = $_SESSION['isAdmin'];

            $this->empId = $_SESSION['empNumber'];

            $partiAssignService = new ParticipateAssignTrainService();
            $this->partiAssignService = $partiAssignService;
            $tSearchService=new TrainingSearchService();
            $this->sorter = new ListSorter('trainsummery.sort', 'TandD_module', $this->getUser(), array('lastName', ListSorter::ASCENDING));

            $this->sorter->setSort(array($request->getParameter('sort'), $request->getParameter('order')));

//            if ($request->getParameter('mode') == 'search') {
//                if ($request->getParameter('searchMode') != 'all' && trim($request->getParameter('searchValue')) == '') {
//                    $this->setMessage('NOTICE', array('Select the field to search'));
//                    $this->redirect('training/Trainsummery');
//                }
//            }
            $this->searchMode = ($request->getParameter('searchMode') == '') ? 'all' : $request->getParameter('searchMode');
            $this->searchValue = ($request->getParameter('searchValue') == '') ? '' : $request->getParameter('searchValue');

            $this->sort = ($request->getParameter('sort') == '') ? 't.td_course_id' : $request->getParameter('sort');
            $this->order = ($request->getParameter('order') == '') ? 'ASC' : $request->getParameter('order');

            $res = $tSearchService->searchEmployeeTrainParticipate($this->searchMode, $this->searchValue, $this->culture, $request->getParameter('page'), $this->sort, $this->order);
            $this->trainSummeryList = $res['data'];
            $this->pglay = $res['pglay'];
            $this->pglay->setTemplate('<a href="{%url}">{%page}</a>');
            $this->pglay->setSelectedTemplate('{%page}');
            if (count($res['data']) <= 0) {
                $this->setMessage('SUCCESS', array($this->getContext()->getI18N()->__("Sorry,Your Search did not Match any Records.", $args, 'messages')));
            }
            
        } catch (sfStopException $sf) {
            
        } catch (Exception $e) {

            $errMsg = new CommonException($e->getMessage(), $e->getCode());
            $this->setMessage('WARNING', $errMsg->display());

            $this->redirect('default/error');
        }
    }

    public function executeGetListedEmpids(sfWebRequest $request) {
        $partiAssign = new ParticipateAssignTrainService();
        $Cid = $request->getParameter('cname');
        $empidList = $partiAssign->GetListedEmpids($Cid);
        $this->empidList = $empidList;
    }

    public function executeDeleteSavedTrain(sfWebRequest $request) {
        $partiAssign = new ParticipateAssignTrainService();
        try {
            $conn = Doctrine_Manager::getInstance()->connection();
            $conn->beginTransaction();
            $conHandler = new ConcurrencyHandler();
              $trainingDeleteService=new DeleteTrainingService();
            $trainrecord=$partiAssign->readworkflowdeleteAssign($request->getParameter('cId'), $request->getParameter('empId'));
            
            $this->isDeleted = $trainingDeleteService->deleteSavedAssign($request->getParameter('cId'), $request->getParameter('empId'));
            $trainingDeleteService->deleteSavedAssign($abc[0], $abc[1]);
            $trainingDeleteService->deleteWfMainAppPerson($trainrecord[0]['wfmain_id']);
            $trainingDeleteService->deleteWfMain($trainrecord[0]['wfmain_id']);
            $conn->commit();

            if ($this->isDeleted) {
                $conHandler->resetTableLock('hs_hr_td_assignlist', array($request->getParameter('empId'), $request->getParameter('cId')), 1);
            }
        } catch (Doctrine_Connection_Exception $e) {
            $conn->rollback();
            $errMsg = new CommonException($e->getPortableMessage(), $e->getPortableCode());
            $this->setMessage('WARNING', $errMsg->display());
            $this->redirect('training/assigntrain?lock=1');
        } catch (Exception $e) {
            $conn->rollback();
            $errMsg = new CommonException($e->getMessage(), $e->getCode());
            $this->setMessage('WARNING', $errMsg->display());
            $this->redirect('training/assigntrain?lock=1');
        }
    }

    public function executeUpdateAssigntrain(sfWebRequest $request) {

        $this->culture = $this->getUser()->getCulture();
        $instCourseService = new InstituteCourceService();
        $this->instList = $instCourseService->getInstitutelist();
    }

    public function executeCheckcourse(sfWebRequest $request) {

        $this->culture = $this->getUser()->getCulture();
        $instCourseService = new InstituteCourceService();

        $id = $request->getParameter('id');
        $partiAssign = new ParticipateAssignTrainService();
        $isCourse = $partiAssign->getcheckCourse($id);
        if (strlen($isCourse[0]['td_course_id'])) {
            $this->isThere = "yes";
        } else {
            $this->isThere = "no";
        }
    }

    public function executeAjaxloadcourse(sfWebRequest $request) {

        $this->culture = $this->getUser()->getCulture();
        $id = $request->getParameter('cid');

        $partiAssign = new ParticipateAssignTrainService();
        $this->courslist = $partiAssign->loadCourseList($id);
    }

    public function executeAjaxloadcourseDetails(sfWebRequest $request) {

        $this->culture = $this->getUser()->getCulture();
        $id = $request->getParameter('cid');

        $instCourseService = new InstituteCourceService();
        $courslist = $instCourseService->LoadCourse($id);
        $this->year = $courslist->getTd_course_year();

        echo json_encode(array("year" => $this->year));
        die;
    }

    public function executeLoadEmployeeDetails(sfWebRequest $request) {

        
        $partiAssignService = new ParticipateAssignTrainService();
        $this->empId = $_SESSION['empNumber'];

        $this->culture = $this->getUser()->getCulture();

        $empdetails = $partiAssignService->LoadEmployeeDetails($this->empId);


        if ($this->culture == "en") {
            $EName = "getEmp_display_name";
        } else {
            $EName = "getEmp_display_name_" . $this->culture;
        }
        if ($empdetails->$EName() == null || $empdetails->$EName() == " ") {
            $this->fullName = $empdetails->getEmp_display_name();
        } else {
            $this->fullName = $empdetails->$EName();
        }


        if ($this->culture == "en") {
            $EName = "title";
        } else {
            $EName = "title_" . $this->culture;
        }

        if ($empdetails->subDivision->$EName == null || $empdetails->subDivision->$EName == " ") {
            $this->workstaion = $empdetails->subDivision->title;
        } else {
            $this->workstaion = $empdetails->subDivision->$EName;
        }

        if ($this->culture == "en") {
            $EName = "name";
        } else {
            $EName = "name_" . $this->culture;
        }
        if ($empdetails->jobTitle->$EName == null || $empdetails->jobTitle->$EName == " ") {
            $this->jobTitle = $empdetails->jobTitle->name;
        } else {
            $this->jobTitle = $empdetails->jobTitle->$EName;
        }

        $this->nic = $empdetails->getEmp_nic_no();

        if ($this->culture == "en") {
            $off_add1 = $empdetails->EmpContact->con_off_addLine1;
            $off_add2 = $empdetails->EmpContact->con_off_addLine2;
        } else {
            $add1 = "con_off_addLine1_" . $this->culture;
            $add2 = "con_off_addLine2_" . $this->culture;

            $off_add1 = $empdetails->EmpContact->$add1;
            if ($off_add1 == "") {
                $off_add1 = $empdetails->EmpContact->con_off_addLine1;
            }
            $off_add2 = $empdetails->EmpContact->$add2;
            if ($off_add2 == "") {
                $off_add2 = $empdetails->EmpContact->con_off_addLine2;
            }
        }

        $this->off_address = $off_add1 . "\n" . $off_add2;
        $this->off_phone = $empdetails->EmpContact->getCon_off_direct();
        $this->mobile = $empdetails->EmpContact->getCon_res_mobile();
        $this->resphone = $empdetails->EmpContact->getCon_res_phone();
        $this->fax = $empdetails->EmpContact->getCon_off_fax();
    }

    public function executeLoadGrid(sfWebRequest $request) {
        $this->culture = $this->getUser()->getCulture();
        $partiAssign = new ParticipateAssignTrainService();
        $empId = $request->getParameter('empid');

        $this->emplist = $partiAssign->getEmployee($empId);
    }

    public function executeNewregister(sfWebRequest $request) {

        try {
            $this->culture = $this->getUser()->getCulture();
            $this->isAdmin = $_SESSION['isAdmin'];
            $this->empId = $_SESSION['empNumber'];

            $trainRegiService = new TrainingRegisterService();
            $this->trainRegiService = $trainRegiService;

            $this->sorter = new ListSorter('trainsummery.sort', 'TandD_module', $this->getUser(), array('lastName', ListSorter::ASCENDING));

            $this->sorter->setSort(array($request->getParameter('sort'), $request->getParameter('order')));

//            if ($request->getParameter('mode') == 'search') {
//                if ($request->getParameter('searchMode') != 'all' && trim($request->getParameter('searchValue')) == '') {
//                    $this->setMessage('NOTICE', array('Select the field to search'));
//                    $this->redirect('training/Trainsummery');
//                }
//            }
            $this->searchMode = ($request->getParameter('searchMode') == '') ? 'all' : $request->getParameter('searchMode');
            $this->searchValue = ($request->getParameter('searchValue') == '') ? '' : $request->getParameter('searchValue');

            $this->sort = ($request->getParameter('sort') == '') ? 'e.emp_display_name' : $request->getParameter('sort');
            $this->order = ($request->getParameter('order') == '') ? 'ASC' : $request->getParameter('order');

            $res = $trainRegiService->EmployeeTrainingHistory($this->searchMode, $this->searchValue, $this->culture, $request->getParameter('page'), $this->sort, $this->order);
            $this->trainSummeryList = $res['data'];
            $this->pglay = $res['pglay'];
            $this->pglay->setTemplate('<a href="{%url}">{%page}</a>');
            $this->pglay->setSelectedTemplate('{%page}');
        
        } catch (sfStopException $sf) {    
            
        } catch (Exception $e) {


            $errMsg = new CommonException($e->getMessage(), $e->getCode());

            $this->setMessage('WARNING', $errMsg->display());



            $this->redirect('default/error');
        }
    }

    public function executeSaveTrainRequest(sfWebRequest $request) {

        $this->culture = $this->getUser()->getCulture();
        $instCourseService = new InstituteCourceService();
        
        $partiAssignService = new ParticipateAssignTrainService();
        $wfDao = new workflowDao();

        $this->empId = $_SESSION['empNumber'];

        $this->instList = $instCourseService->getInstitutelist();

        $HeadDiv = $partiAssignService->getDivHeadorApprover($this->empId);

        $this->cid = $request->getParameter('cid1');


        
        $sysConf = OrangeConfig::getInstance()->getSysConf();
        $hie_code = $sysConf->hie_code;
        $Headoffice = $sysConf->Headoffice;
        $DivisionSecretory = $sysConf->DivisionSecretory;
        $DistrictSecretory = $sysConf->DistrictSecretory;
        $HRTeam = $sysConf->HRTeam;
        $HRAdmin = $sysConf->HRAdmin;

        $this->insid = $request->getParameter('insid');
        $empDeatils = $partiAssignService->LoadEmployeeDetails($this->empId);

        if ($request->isMethod('post')) {

            try {
                $trainassign = new TrainAssign();
                $trainassign->setEmp_number($this->empId);

                if (strlen($request->getParameter('cmbcourseid'))) {
                    $trainassign->setTd_course_id($request->getParameter('cmbcourseid'));
                } else {
                    $trainassign->setTd_course_id(null);
                }
                $trainassign->setTd_asl_isattend('0');
                //$trainassign->setTd_asl_isapproved('1');
                $trainassign->setTd_asl_ispending('0');


                $trainassign->setTd_asl_year($request->getParameter('txttrainYear'));
                
                $sysConf = OrangeConfig::getInstance()->getSysConf();
                        
                $Supervisor=$instCourseService->readEmployeeSupervisor($employeeID);
                $Coursetype=$instCourseService->readCourse($request->getParameter('cmbcourseid'));
                //die(print_r($Coursetype->td_approval_type));  
                if($Supervisor->supervisorId != null){

                 $TRNPOS1=  $sysConf->TRNPOS1; 
                $trainassign->setApp_emp_number($Supervisor->supervisorId);
                $trainassign->setApp_position($TRNPOS1);
                $trainassign->setTd_approval_type($Coursetype->td_approval_type);
                }else{
                    $this->setMessage('WARNING', array($this->getContext()->getI18N()->__("Please assign a supervisor.", $args, 'messages')));
                    $this->redirect('training/assigntrain');
                }
                        
                

                $employee = $this->empId;

                $empDeatils = $partiAssignService->LoadEmployeeDetails($employee);
                // WF
                /*
                $HRAdmin = $partiAssignService->getCompanyStructureDetailRole($employee, $HRAdmin);
                        if ($HRAdmin->CompanyStructure->def_level != null) {//die("HRAdminApproved");
                            $trainassign->setTd_asl_status('5');
                            $trainassign->setTd_asl_isapproved('1');
                             $returnWF[0]="app";

                        } else {
                            $HRTeam = $partiAssignService->getCompanyStructureDetailRole($employee, $HRTeam);

                            if ($HRTeam->CompanyStructure->def_level != null) {//die("HRAdmin");
                                $trainassign->setTd_asl_status('4');
                                //die($employeeID);
                                $returnWF = $wfDao->startWorkFlow(6, $employee);
                            } else {
                                $LoginEmpDeatilsDistrict = $partiAssignService->getCompanyStructureDetailRole($employee, $DistrictSecretory);
                                if ($LoginEmpDeatilsDistrict->CompanyStructure->def_level != null) {
                                    $Dishiecode = "hie_code_" . $LoginEmpDeatilsDistrict->CompanyStructure->def_level;
                                } else {
                                    $Dishiecode = "hie_code_1";
                                }
                                    
                                if ($empDeatils->$Dishiecode == $LoginEmpDeatilsDistrict->CompanyStructure->id) {//die("DisSec");
                                    $returnWF = $wfDao->startWorkFlow(4, $employee);
                                    $trainassign->setTd_asl_status('2');
                                } else {

                                    $LoginEmpDeatils = $partiAssignService->getCompanyStructureDetailRole($employee, $DivisionSecretory);
                                    if ($LoginEmpDeatils->CompanyStructure->def_level != null) {
                                        $Divhiecode = "hie_code_" . $LoginEmpDeatils->CompanyStructure->def_level;
                                    } else {
                                        $Divhiecode = "hie_code_1";
                                    }
                                    $Divhiecode = $Divhiecode;
                                    if ($empDeatils->$Divhiecode == $LoginEmpDeatils->CompanyStructure->id) {//die("HRTeam");
                                        $returnWF = $wfDao->startWorkFlow(5, $employee);
                                        $trainassign->setTd_asl_status('3');
                                    } else {
                                        



                                        if ($empDeatils->$hie_code == $Headoffice) {//die("HRTeam2");
                                            $returnWF = $wfDao->startWorkFlow(5, $employee);
                                            $trainassign->setTd_asl_status('3');
                                            $trainassign->setWfmain_id($returnWF[0]);
                                            $trainassign->setWfmain_sequence(1);
                                        } else {
                                            if ($HeadDiv[0]['CompanyStructure'][0]['def_level'] > ($sysConf->DivisionLevel - 1)) {//die("DivSec1");
                                                
                                                $returnWF = $wfDao->startWorkFlow(3, $employee);
                                                
                                                $trainassign->setTd_asl_status('1');
                                            } else if ($HeadDiv[0]['CompanyStructure'][0]['def_level'] > ($sysConf->DistrictLevel - 1)) {//die("DisSec1");
                                               
                                                $returnWF = $wfDao->startWorkFlow(4, $employee);
                                                $trainassign->setTd_asl_status('2');
                                               
                                            } else if ($HeadDiv[0]['CompanyStructure'][0]['def_level'] > 2) {//die("HRTeam1");
                                                $returnWF = $wfDao->startWorkFlow(5, $employee);
                                                $trainassign->setTd_asl_status('3');
                                            } else if ($HeadDiv[0]['CompanyStructure'][0]['def_level'] > 1) {//die("HRAdmin1");
                                                $returnWF = $wfDao->startWorkFlow(5, $employee);
                                                $trainassign->setTd_asl_status('4');
                                            }
                                        }
                                    }
                                }
                            }
                        }
                        if ($returnWF == null || $returnWF[0] == "-1") {

                            throw new CommonException(null, 105);
                        } else {
                            if($returnWF[0]=="app"){
                            $trainassign->setWfmain_id(null);
                            $trainassign->setWfmain_sequence(null);
                            }else{
                            $trainassign->setWfmain_id($returnWF[0]);
                            $trainassign->setWfmain_sequence(1);
                            }
                        }
                        */
                        //--
                $saved = $partiAssignService->saveAssignList($trainassign);
            } catch (Doctrine_Connection_Exception $e) {
                $errMsg = new CommonException($e->getPortableMessage(), $e->getPortableCode());
                $this->setMessage('WARNING', $errMsg->display());
                $this->redirect('training/SaveTrainRequest');
            } catch (Exception $e) {


                $errMsg = new CommonException($e->getMessage(), $e->getCode());

                $this->setMessage('WARNING', $errMsg->display());



                $this->redirect('training/SaveTrainRequest');
            }

            $this->setMessage('SUCCESS', array('Successfully Added'));
            $this->redirect('training/SaveTrainRequest');
        }
    }

    public function executeUpdateTrainRequest(sfWebRequest $request) {
        
    }

    public function executeAdminapp(sfWebRequest $request) {


        try {
            $this->culture = $this->getUser()->getCulture();
            $InstituteCourceService = new InstituteCourceService();
            $this->InstituteCourceService = $InstituteCourceService;

            $this->sorter = new ListSorter('training.sort', 't&d_module', $this->getUser(), array('t.trans_id', ListSorter::ASCENDING));

            $this->sorter->setSort(array($request->getParameter('sort'), $request->getParameter('order')));

//            if ($request->getParameter('mode') == 'search') {
//                if ($request->getParameter('searchMode') != 'all' && trim($request->getParameter('searchValue')) == '') {
//                    $this->setMessage('NOTICE', array('Select the field to search'));
//                    $this->redirect('Transfer/NewTransfer');
//                }
//            }
            $this->searchMode = ($request->getParameter('searchMode') == '') ? 'all' : $request->getParameter('searchMode');
            $this->searchValue = ($request->getParameter('searchValue') == '') ? '' : $request->getParameter('searchValue');

            $this->sort = ($request->getParameter('sort') == '') ? 'e.emp_display_name' : $request->getParameter('sort');
            $this->order = ($request->getParameter('order') == '') ? 'ASC' : $request->getParameter('order');
            $trainApprovalService = new TrainApprovalService();
            $res = $trainApprovalService->getPendingList($this->searchMode, $this->searchValue, $this->culture, $request->getParameter('page'), $this->sort, $this->order);
            $this->trainSummeryList = $res['data'];


            $this->pglay = $res['pglay'];
            $this->pglay->setTemplate('<a href="{%url}">{%page}</a>');
            $this->pglay->setSelectedTemplate('{%page}');
            if (count($res['data']) <= 0) {
                $this->setMessage('SUCCESS', array($this->getContext()->getI18N()->__("Sorry,Your Search did not Match any Records.", $args, 'messages')));
            }
            
        } catch (sfStopException $sf) {
            
        } catch (Exception $e) {

            $errMsg = new CommonException($e->getMessage(), $e->getCode());
            $this->setMessage('WARNING', $errMsg->display());

            $this->redirect('default/error');
        }
    }

    public function executeSaveAdminApp(sfWebRequest $request) {
        $InstituteCourceService = new InstituteCourceService();
        $this->InstituteCourceService = $InstituteCourceService;
        $ParticipateAssignTrainService= new ParticipateAssignTrainService();
        $instCourseService = new InstituteCourceService();
        $trainApprovalDao = new TrainApprovalDao();
        $sysConf = OrangeConfig::getInstance()->getSysConf();

        $empId = $request->getParameter('empId');
        $Cid = $request->getParameter('cId');
        $status = $request->getParameter('value');
        $conn = Doctrine_Manager::getInstance()->connection();
        $conn->beginTransaction();

        try {
            //if ($status != 0) {
                $TrainingEmployee=$trainApprovalDao->getTainingapllication($empId,$Cid);
                
                if($TrainingEmployee->td_approval_type != null && $TrainingEmployee->app_position != null){
                    
                    switch ($TrainingEmployee->app_position) {  
                        case "1": 
                            //die(print_r("case 1"));
                            $Supervisor=$instCourseService->readEmployeeSupervisor($TrainingEmployee->app_emp_number);
                            if($Supervisor->supervisorId != null){ 
                                $TrainingEmployee->setApp_emp_number($Supervisor->supervisorId);
                            }else{
                                $this->setMessage('WARNING', array($this->getContext()->getI18N()->__("Please assign a supervisor.", $args, 'messages')));
                                $this->redirect('training/assigntrain');
                            }                            
                            $TrainingEmployee->setApp_position("2");  
                            
                            break;
                            
                        case "2":
                            //die(print_r("case 2"));
                            $Emp=$instCourseService->readTrainingApprovalInDesignationWise($sysConf->TRNDESC3);
                            if($Emp->empNumber != null){
                                $TrainingEmployee->setApp_emp_number($Emp->empNumber);
                            }else{
                                $this->setMessage('WARNING', array($this->getContext()->getI18N()->__("Please assign a Designation.", $args, 'messages')));
                                $this->redirect('training/assigntrain');
                            }                            
                            $TrainingEmployee->setApp_position("3");   
//                            if($TrainingEmployee->td_approval_type == "1"){
//                                $TrainingEmployee->setTd_asl_isapproved("1"); 
//                            }
                            break;
                        case "3":
                            //die(print_r("case 3"));
                            $TrainingEmployee->setApp_position("4");  
                            if($TrainingEmployee->td_approval_type == "1"){
                                $TrainingEmployee->setTd_asl_isapproved("1"); 
                            }else{
                               $Emp=$instCourseService->readTrainingApprovalInDesignationWise($sysConf->TRNDESC4);
                                if($Emp->empNumber != null){
                                    $TrainingEmployee->setApp_emp_number($Emp->empNumber);
                                }else{
                                    $this->setMessage('WARNING', array($this->getContext()->getI18N()->__("Please assign a Designation.", $args, 'messages')));
                                    $this->redirect('training/assigntrain');
                                }
                            }
                            break;
                        case "4": 
                           //die(print_r("case 4"));
                            $TrainingEmployee->setApp_position("5");  
                            if($TrainingEmployee->td_approval_type == "2"){
                                $TrainingEmployee->setTd_asl_isapproved("1"); 
                                
                                        $e = getdate();
                                        $today = date("Y-m-d", $e[0]);    

                                        $EmployeeNotifiation = new NotificationEmployee();
                                        $EmployeeNotifiation->setMod_id("Traning");
                                        $message = "Training Approved";
                                        $EmployeeNotifiation->setNot_message($message);
                                        $EmployeeNotifiation->setEmp_number($empId);
                                        $EmployeeNotifiation->setStatus(0);
                                        $EmployeeNotifiation->setCreate_date($today);
                                        $EmployeeNotifiation->setCreate_emp_number($TrainingEmployee->app_emp_number);
                                        $EmployeeNotifiation->save();
        
                            }else{
                                $Emp=$instCourseService->readTrainingApprovalInDesignationWise($sysConf->TRNDESC5);
                                if($Emp->empNumber != null){
                                    $TrainingEmployee->setApp_emp_number($Emp->empNumber);
                                }else{
                                    $this->setMessage('WARNING', array($this->getContext()->getI18N()->__("Please assign a Designation.", $args, 'messages')));
                                    $this->redirect('training/assigntrain');
                                } 
                            }
                            break;
                            
                        case "5":
                           //die(print_r("case 5"));
                            $TrainingEmployee->setApp_position("6");                            
                            if($TrainingEmployee->td_approval_type == "3"){
                                $TrainingEmployee->setTd_asl_isapproved("1"); 
                                                                
                                        $e = getdate();
                                        $today = date("Y-m-d", $e[0]);    

                                        $EmployeeNotifiation = new NotificationEmployee();
                                        $EmployeeNotifiation->setMod_id("Traning");
                                        $message = "Training Approved";
                                        $EmployeeNotifiation->setNot_message($message);
                                        $EmployeeNotifiation->setEmp_number($empId);
                                        $EmployeeNotifiation->setStatus(0);
                                        $EmployeeNotifiation->setCreate_date($today);
                                        $EmployeeNotifiation->setCreate_emp_number($TrainingEmployee->app_emp_number);
                                        $EmployeeNotifiation->save();
                            }else{ 
                                $Emp=$instCourseService->readTrainingApprovalInDesignationWise($sysConf->TRNDESC6);
                                if($Emp->empNumber != null){ 
                                    $TrainingEmployee->setApp_emp_number($Emp->empNumber);
                                }else{
                                    $this->setMessage('WARNING', array($this->getContext()->getI18N()->__("Please assign a Designation.", $args, 'messages')));
                                    $this->redirect('training/assigntrain');
                                } 
                            } 
                            break;
                            
                           case "6":
                           
                             //die(print_r("case 6"));                         
                            if($TrainingEmployee->td_approval_type == "4"){
                                $TrainingEmployee->setTd_asl_isapproved("1"); 
                                                                
                                        $e = getdate();
                                        $today = date("Y-m-d", $e[0]);    

                                        $EmployeeNotifiation = new NotificationEmployee();
                                        $EmployeeNotifiation->setMod_id("Traning");
                                        $message = "Training Approved";
                                        $EmployeeNotifiation->setNot_message($message);
                                        $EmployeeNotifiation->setEmp_number($empId);
                                        $EmployeeNotifiation->setStatus(0);
                                        $EmployeeNotifiation->setCreate_date($today);
                                        $EmployeeNotifiation->setCreate_emp_number($TrainingEmployee->app_emp_number);
                                        $EmployeeNotifiation->save();
                            }
                            
                            break;   
                            
                }

                    $TrainingEmployee->save();
                }
                //$trainApprovalService = new TrainApprovalService();
                //$this->isupdated = $trainApprovalService->updateAprovel($empId, $Cid, $status);
                $conn->commit();
            //}
        } catch (Doctrine_Connection_Exception $e) {
            $conn->rollBack();
            $errMsg = new CommonException($e->getPortableMessage(), $e->getPortableCode());
            $this->setMessage('WARNING', $errMsg->display());
            $this->redirect('training/Adminapp');
        } catch (Exception $e) {
            $conn->rollBack();
            $errMsg = new CommonException($e->getMessage(), $e->getCode());
            $this->setMessage('WARNING', $errMsg->display());

            $this->redirect('training/Adminapp');
        }
        $this->isupdated = "true";
    }

    public function executeAjaxTableLock(sfWebRequest $request) {


        if (!strlen($request->getParameter('lock'))) {
            $this->lockMode = 0;
        } else {
            $this->lockMode = $request->getParameter('lock');
        }

        $empId = $request->getParameter('empId');
        $Cid = $request->getParameter('cId');

        if (isset($this->lockMode)) {
            if ($this->lockMode == 1) {

                $conHandler = new ConcurrencyHandler();

                $recordLocked = $conHandler->setTableLock('hs_hr_td_assignlist', array($empId, $Cid), 3);

                if ($recordLocked) {


                    $this->lockMode = 1;
                } else {

                    $this->lockMode = 0;
                }
            } else if ($this->lockMode == 0) {

                $conHandler = new ConcurrencyHandler();
                $recordLocked = $conHandler->resetTableLock('hs_hr_td_assignlist', array($empId, $Cid), 3);
                $this->lockMode = 0;
            }
        }
    }

    public function executeEditAdminApp(sfWebRequest $request) {

        try {
            $this->culture = $this->getUser()->getCulture();
            $InstituteCourceService = new InstituteCourceService();
            $this->InstituteCourceService = $InstituteCourceService;

            $this->sorter = new ListSorter('training.sort', 't&d_module', $this->getUser(), array('t.trans_id', ListSorter::ASCENDING));

            $this->sorter->setSort(array($request->getParameter('sort'), $request->getParameter('order')));

//            if ($request->getParameter('mode') == 'search') {
//                if ($request->getParameter('searchMode') != 'all' && trim($request->getParameter('searchValue')) == '') {
//                    $this->setMessage('NOTICE', array('Select the field to search'));
//                    $this->redirect('training/Adminapp');
//                }
//            }
            $this->searchMode = ($request->getParameter('searchMode') == '') ? 'all' : $request->getParameter('searchMode');
            $this->searchValue = ($request->getParameter('searchValue') == '') ? '' : $request->getParameter('searchValue');

            $this->sort = ($request->getParameter('sort') == '') ? 'e.emp_display_name' : $request->getParameter('sort');
            $this->order = ($request->getParameter('order') == '') ? 'ASC' : $request->getParameter('order');
            $trainApprovalService = new TrainApprovalService();
            $res = $trainApprovalService->getApprovedListList($this->searchMode, $this->searchValue, $this->culture, $request->getParameter('page'), $this->sort, $this->order);
            $this->trainSummeryList = $res['data'];

            $this->pglay = $res['pglay'];
            $this->pglay->setTemplate('<a href="{%url}">{%page}</a>');
            $this->pglay->setSelectedTemplate('{%page}');
            if (count($res['data']) <= 0) {
                $this->setMessage('SUCCESS', array($this->getContext()->getI18N()->__("Sorry,Your Search did not Match any Records.", $args, 'messages')));
            }
            
        } catch (sfStopException $sf) {
            
        } catch (Exception $e) {

            $errMsg = new CommonException($e->getMessage(), $e->getCode());
            $this->setMessage('WARNING', $errMsg->display());

            $this->redirect('default/error');
        }
    }

    public function executeSaveEditAdminApp(sfWebRequest $request) {

        $status = $request->getParameter('value');
        $cid = $request->getParameter('cId');
        $empid = $request->getParameter('empId');

       

        try {
            $trainApprovalService = new TrainApprovalService();
            $this->isupdated = $trainApprovalService->updateEditAprovel($empid, $cid, $status);
        } catch (Doctrine_Connection_Exception $e) {

            $errMsg = new CommonException($e->getPortableMessage(), $e->getPortableCode());
            $this->setMessage('WARNING', $errMsg->display());
            $this->redirect('training/EditAdminApp');
        } catch (Exception $e) {
            $errMsg = new CommonException($e->getMessage(), $e->getCode());
            $this->setMessage('WARNING', $errMsg->display());

            $this->redirect('training/EditAdminApp');
        }
        $this->isupdated = "true";
    }

    public function executeNewEmpTrainRecord(sfWebRequest $request) {
        $this->culture = $this->getUser()->getCulture();
        $id = $request->getParameter('cid');
        $userType = $request->getParameter('user');
        $this->userType = $userType;
        $partiAssignService = new ParticipateAssignTrainService();

        $instCourseService = new InstituteCourceService();
        $this->instList = $instCourseService->getInstitutelist();
        $this->courslist = $partiAssignService->loadCourseList($id);

        if ($request->isMethod('post')) {

            try {

                $this->empId = $_SESSION['empNumber'];
                                

                if (strlen($request->getParameter('txthidden'))) {
                    $isRecordsubmit = "1";
                }

                $cousId = $request->getParameter('cmbcourseid');

                $trainRecordRead = $instCourseService->readTrainRecords(trim($this->empId), trim($cousId));

                $trainRecordRead->setTd_asl_isempfb($isRecordsubmit);

                $trainRecordRead->setTd_asl_duration($request->getParameter('txtDuration'));

                $trainRecordRead->setTd_asl_conductperson($request->getParameter('txtCondPers'));

                $trainRecordRead->setTd_asl_content($request->getParameter('txtContent'));

                $trainRecordRead->setTd_asl_conductdate($request->getParameter('txtDate'));

                $trainRecordRead->setTd_asl_remarks($request->getParameter('txtRemarks'));
                if (strlen($request->getParameter('txtEffect'))) {

                    $trainRecordRead->setTd_asl_effectiveness($request->getParameter('txtEffect'));
                }
                if (strlen($request->getParameter('txtAdminremarks'))) {

                    $trainRecordRead->setTd_asl_adminremarks($request->getParameter('txtAdminremarks'));
                }

                $trainRecordRead->save();
            } catch (Doctrine_Connection_Exception $e) {

                $errMsg = new CommonException($e->getPortableMessage(), $e->getPortableCode());
                $this->setMessage('WARNING', $errMsg->display());
                $this->redirect('training/SummeryTrainRecord?user=' . $userType);
            } catch (Exception $e) {
                $errMsg = new CommonException($e->getMessage(), $e->getCode());
                $this->setMessage('WARNING', $errMsg->display());

                $this->redirect('training/SummeryTrainRecord?user=' . $userType);
            }


            $this->setMessage('SUCCESS', array('Successfully Added'));

            $this->redirect('training/SummeryTrainRecord?user=' . $userType);
        }
    }

    public function executeUpdateTrainRecord(sfWebRequest $request) {

        $usertype = $request->getParameter('userType');
        $this->userType = $usertype;

        $this->isAdmin = $_SESSION['isAdmin'];

        $this->culture = $this->getUser()->getCulture();
        $id = $request->getParameter('cid');
        $encrypt = new EncryptionHandler();
        $empid = $encrypt->decrypt($request->getParameter('empid'));
        $courseId = $encrypt->decrypt($request->getParameter('corsid'));

        $instCourseService = new InstituteCourceService();


        $this->trainDao = $instCourseService;
        $this->instList = $instCourseService->getInstitutelist();
        $partiAssignService = new ParticipateAssignTrainService();
        $this->courslist = $partiAssignService->loadCourseList($id);
        if (!$this->courslist) {
            $this->setMessage('WARNING', array($this->getContext()->getI18N()->__('Can not update. Record has been Deleted', $args, 'messages')));
            $this->redirect('training/CourseList');
        }
        $this->trainRecordlist = $instCourseService->getTrainRecordListUpdate($empid, $courseId);

        if (!strlen($request->getParameter('lock'))) {
            $this->lockMode = 0;
        } else {
            $this->lockMode = $request->getParameter('lock');
        }


        if (isset($this->lockMode)) {
            if ($this->lockMode == 1) {

                $conHandler = new ConcurrencyHandler();

                $recordLocked = $conHandler->setTableLock('hs_hr_td_assignlist', array($empid, $courseId), 5);

                if ($recordLocked) {


                    $this->lockMode = 1;
                } else {


                    $this->setMessage('WARNING', array($this->getContext()->getI18N()->__('Can not update. Record locked by another user.', $args, 'messages')), false);
                    $this->lockMode = 0;
                }
            } else if ($this->lockMode == 0) {

                $conHandler = new ConcurrencyHandler();

                $recordLocked = $conHandler->resetTableLock('hs_hr_td_assignlist', array($empid, $courseId), 5);
                $this->lockMode = 0;
            }
        }

        if ($request->isMethod('post')) {

            try {
                if ($usertype == "Ess") {
                    $this->empId = $_SESSION['empNumber'];
                } else {
                    $this->empId = $encrypt->decrypt($request->getParameter('empid'));
                }

                $trainassign = new TrainAssign();
                $empId = $this->empId;

                $trainRecordRead = $instCourseService->readTrainRecords(trim($empId), trim($courseId));

                $trainRecordRead->setTd_asl_isempfb("1");
                $trainRecordRead->setTd_asl_duration($request->getParameter('txtDuration'));

                $trainRecordRead->setTd_asl_conductperson($request->getParameter('txtCondPers'));

                $trainRecordRead->setTd_asl_content($request->getParameter('txtContent'));

                $trainRecordRead->setTd_asl_conductdate($request->getParameter('txtDate'));

                $trainRecordRead->setTd_asl_remarks($request->getParameter('txtRemarks'));
                if (strlen($request->getParameter('txtEffect'))) {

                    $trainRecordRead->setTd_asl_effectiveness($request->getParameter('txtEffect'));
                }
                if (strlen($request->getParameter('txtAdminremarks'))) {

                    $trainRecordRead->setTd_asl_adminremarks($request->getParameter('txtAdminremarks'));
                }


                if (strlen($request->getParameter('txtAdminremarks')) || strlen($request->getParameter('txtEffect'))) {


                    $isadmincomment = "1";
                } else {
                    $isadmincomment = "0";
                }
                $trainRecordRead->setTd_asl_isadcommented($isadmincomment);

                $trainRecordRead->save();
            } catch (Exception $e) {
                $errMsg = new CommonException($e->getMessage(), $e->getCode());
                $this->setMessage('WARNING', $errMsg->display());

                $this->redirect('training/SummeryTrainRecord?user=' . $usertype);
            }


            $this->setMessage('SUCCESS', array('Successfully Added'));
            $this->redirect('training/UpdateTrainRecord?lock=0&empid=' . $encrypt->encrypt($this->trainRecordlist[0]['emp_number']) . '&corsid=' . $encrypt->encrypt($this->trainRecordlist[0]['td_course_id']) . '&mode=edit&userType=' . $usertype);
        }
    }

    public function executeSummeryTrainRecord(sfWebRequest $request) {

        try {
            $this->culture = $this->getUser()->getCulture();

            $InstituteCourceService = new InstituteCourceService();
            $this->InstituteCourceService = $InstituteCourceService;

            $userType = $request->getParameter('user');

            $this->userType = $userType;



            $this->sorter = new ListSorter('training.sort', 't&d_module', $this->getUser(), array('t.trans_id', ListSorter::ASCENDING));

            $this->sorter->setSort(array($request->getParameter('sort'), $request->getParameter('order')));

//            if ($request->getParameter('mode') == 'search') {
//                if ($request->getParameter('searchMode') != 'all' && trim($request->getParameter('searchValue')) == '') {
//                    $this->setMessage('NOTICE', array('Select the field to search'));
//                    $this->redirect('training/Adminapp');
//                }
//            }
            $this->searchMode = ($request->getParameter('searchMode') == '') ? 'all' : $request->getParameter('searchMode');
            $this->searchValue = ($request->getParameter('searchValue') == '') ? '' : $request->getParameter('searchValue');

            $this->sort = ($request->getParameter('sort') == '') ? 'e.emp_display_name' : $request->getParameter('sort');
            $this->order = ($request->getParameter('order') == '') ? 'ASC' : $request->getParameter('order');

            $res = $InstituteCourceService->getTrainRecordList($this->searchMode, $this->searchValue, $this->culture, $request->getParameter('page'), $this->sort, $this->order, $userType);

            $this->trainSummeryList = $res['data'];


            $this->pglay = $res['pglay'];
            $this->pglay->setTemplate('<a href="{%url}">{%page}</a>');
            $this->pglay->setSelectedTemplate('{%page}');
            if (count($res['data']) <= 0) {
                $this->setMessage('SUCCESS', array($this->getContext()->getI18N()->__("Sorry,Your Search did not Match any Records.", $args, 'messages')));
            }
        
         } catch (sfStopException $sf) {   
            
        } catch (Exception $e) {

            $errMsg = new CommonException($e->getMessage(), $e->getCode());
            $this->setMessage('WARNING', $errMsg->display());

            $this->redirect('default/error');
        }
    }

    public function executeSummeryTrainRecordAdmin(sfWebRequest $request) {





        try {
            $this->culture = $this->getUser()->getCulture();
            $InstituteCourceService = new InstituteCourceService();
            $this->InstituteCourceService = $InstituteCourceService;



            $this->sorter = new ListSorter('training.sort', 't&d_module', $this->getUser(), array('t.trans_id', ListSorter::ASCENDING));

            $this->sorter->setSort(array($request->getParameter('sort'), $request->getParameter('order')));

//            if ($request->getParameter('mode') == 'search') {
//                if ($request->getParameter('searchMode') != 'all' && trim($request->getParameter('searchValue')) == '') {
//                    $this->setMessage('NOTICE', array('Select the field to search'));
//                    $this->redirect('training/Adminapp');
//                }
//            }
            $this->searchMode = ($request->getParameter('searchMode') == '') ? 'all' : $request->getParameter('searchMode');
            $this->searchValue = ($request->getParameter('searchValue') == '') ? '' : $request->getParameter('searchValue');

            $this->sort = ($request->getParameter('sort') == '') ? 'e.emp_display_name' : $request->getParameter('sort');
            $this->order = ($request->getParameter('order') == '') ? 'ASC' : $request->getParameter('order');

            $res = $InstituteCourceService->getTrainRecordListAdmin($this->searchMode, $this->searchValue, $this->culture, $request->getParameter('page'), $this->sort, $this->order);
            $this->trainSummeryList = $res['data'];

            $this->pglay = $res['pglay'];
            $this->pglay->setTemplate('<a href="{%url}">{%page}</a>');
            $this->pglay->setSelectedTemplate('{%page}');
            if (count($res['data']) <= 0) {
                $this->setMessage('SUCCESS', array($this->getContext()->getI18N()->__("Sorry,Your Search did not Match any Records.", $args, 'messages')));
            }
            
        } catch (sfStopException $sf) {
            
        } catch (Exception $e) {

            $errMsg = new CommonException($e->getMessage(), $e->getCode());
            $this->setMessage('WARNING', $errMsg->display());

            $this->redirect('default/error');
        }
    }

    public function executeCheckUserthere(sfWebRequest $request) {

        $this->empId = $_SESSION['empNumber'];
        $courseId = $request->getParameter('coursId');

        $InstituteCourceService = new InstituteCourceService();
        $trainRegDao = new TrainingRegisterDao();
        $count = $trainRegDao->countAssignedcourse($courseId, $this->empId);

        $count1 = $InstituteCourceService->isrecored($courseId, $this->empId);

        $courseDuration=$InstituteCourceService->courseDuration($courseId);

        $conductDate=$InstituteCourceService->getConductDate($courseId);
        
        $isRejected=$InstituteCourceService->getTrainingStatus($courseId, $this->empId);


        $explodeDate=explode("-",$courseDuration);
        $year=$explodeDate[0];
        $month=$explodeDate[1];
        $date=$explodeDate[2];
        $hours=$explodeDate[3];
        $mins=$explodeDate[4];

        $fulldate=$month." ".$this->getContext()->getI18N()->__("months(s)")." ".$date." ".$this->getContext()->getI18N()->__("days(s)")." ".$hours." ".$this->getContext()->getI18N()->__("hour(s)")." ".$mins." ".$this->getContext()->getI18N()->__("min(s)");
        
        $this->c = $count[0]['count'];
        $this->l = $count1[0]['count'];


        if ($this->c <= 0) {
            $this->msg = "error";
        } else {
            $this->msg = "ok";
        }
        if ($this->l <= 0) {
            $this->msg1 = "ok";
        } else {
            $this->msg1 = "error";
        }

        $this->fulldate=$fulldate;
        $this->conductDate=$conductDate;
        $this->isRejected=$isRejected;
       
    }

    public function executeCheckTrainAssign(sfWebRequest $request) {

        $this->empId = $_SESSION['empNumber'];
        $courseId = $request->getParameter('cid');

        $InstituteCourceService = new InstituteCourceService();
        $trainRegiService = new TrainingRegisterService();
        $count = $trainRegiService->countAssignedcourse($courseId, $this->empId);
        $isRejected=$InstituteCourceService->getTrainingStatus($courseId, $this->empId);

        $this->c = $count[0]['count'];



        if ($this->c != 0) {
            $this->msg = "error";
        } else {
            $this->msg = "ok";
        }
        $this->test = $this->msg;
        $this->isRejected=$isRejected;
    }

    public function executeDeletetrainassiged(sfWebRequest $request) {


        if (count($request->getParameter('chkLocID')) > 0) {

            $partiAssignService = new ParticipateAssignTrainService();
            $trainingDeleteService=new DeleteTrainingService();
            try {
                $conn = Doctrine_Manager::getInstance()->connection();
                $conn->beginTransaction();
                $ids = array();
                $ids = $request->getParameter('chkLocID');

                $countArr = array();
                $saveArr = array();
                for ($i = 0; $i < count($ids); $i++) {
                    $conHandler = new ConcurrencyHandler();
                    $abc = explode("_", $ids[$i]);

                    $isRecordLocked = $conHandler->isTableLocked('hs_hr_td_assignlist', array(trim($abc[1]), $abc[0]), 1);
                    if ($isRecordLocked) {
                        $countArr = $ids[$i];
                    } else {
                        $saveArr = $ids[$i];
                        $trainrecord=$partiAssignService->readworkflowdeleteAssign($abc[0], $abc[1]);
                        
                        $trainingDeleteService->deleteSavedAssign($abc[0], $abc[1]);
                        $trainingDeleteService->deleteWfMainAppPerson($trainrecord[0]['wfmain_id']);
                        $trainingDeleteService->deleteWfMain($trainrecord[0]['wfmain_id']);
                        
                        $conHandler->resetTableLock('hs_hr_td_assignlist', array(trim($abc[1]), $abc[0]), 1);
                    }
                }

                $conn->commit();
            } catch (Doctrine_Connection_Exception $e) {
                $conn->rollBack();
                $errMsg = new CommonException($e->getPortableMessage(), $e->getPortableCode());
                $this->setMessage('WARNING', $errMsg->display());
                $this->redirect('training/trainsummery');
            } catch (Exception $e) {
                $conn->rollBack();
                $errMsg = new CommonException($e->getMessage(), $e->getCode());
                $this->setMessage('WARNING', $errMsg->display());
                $this->redirect('training/trainsummery');
            }
            if (count($saveArr) > 0 && count($countArr) == 0) {
                $this->setMessage('SUCCESS', array($this->getContext()->getI18N()->__("Successfully Deleted", $args, 'messages')));
            } elseif (count($saveArr) > 0 && count($countArr) > 0) {
                $this->setMessage('WARNING', array($this->getContext()->getI18N()->__("Some records are can not be deleted as them  Locked by another user ", $args, 'messages')));
            } elseif (count($saveArr) == 0 && count($countArr) > 0) {
                $this->setMessage('WARNING', array($this->getContext()->getI18N()->__("Can not delete as them  Locked by another user ", $args, 'messages')));
            }
        } else {
            $this->setMessage('NOTICE', array('Select at least one record to delete'));
        }
        $this->redirect('training/trainsummery');
    }

    public function executeDeleteTrainRecord(sfWebRequest $request) {


        if (count($request->getParameter('chkLocID')) > 0) {

            $userType = $request->getParameter('userType');
            $trainRegiService = new TrainingRegisterService();
            try {

                $conn = Doctrine_Manager::getInstance()->connection();
                $conn->beginTransaction();
                $ids = array();
                $ids = $request->getParameter('chkLocID');

                $countArr = array();
                $saveArr = array();
                for ($i = 0; $i < count($ids); $i++) {
                    $conHandler = new ConcurrencyHandler();
                    $abc = explode("_", $ids[$i]);

                    $isRecordLocked = $conHandler->isTableLocked('hs_hr_td_assignlist', array(trim($abc[1]), $abc[0]), 2);
                    if ($isRecordLocked) {
                        $countArr = $ids[$i];
                    } else {
                        $saveArr = $ids[$i];
                        $trainRegiService->deleteTrainRecord($abc[0], $abc[1]);
                      
                        $conHandler->resetTableLock('hs_hr_td_assignlist', array(trim($abc[1]), $abc[0]), 2);
                    }
                }

                $conn->commit();
            } catch (Doctrine_Connection_Exception $e) {
                $conn->rollBack();
                $errMsg = new CommonException($e->getPortableMessage(), $e->getPortableCode());
                $this->setMessage('WARNING', $errMsg->display());
                if ($userType == "Ess") {
                    $this->redirect('training/SummeryTrainRecord?user=Ess');
                } else {
                    $this->redirect('training/SummeryTrainRecord?user=Admin');
                }
            } catch (Exception $e) {
                $conn->rollBack();
                $errMsg = new CommonException($e->getMessage(), $e->getCode());
                $this->setMessage('WARNING', $errMsg->display());
            }
            if (count($saveArr) > 0 && count($countArr) == 0) {
                $this->setMessage('SUCCESS', array($this->getContext()->getI18N()->__("Successfully Deleted", $args, 'messages')));
            } elseif (count($saveArr) > 0 && count($countArr) > 0) {
                $this->setMessage('WARNING', array($this->getContext()->getI18N()->__("Some records are can not be deleted as them  Locked by another user ", $args, 'messages')));
            } elseif (count($saveArr) == 0 && count($countArr) > 0) {
                $this->setMessage('WARNING', array($this->getContext()->getI18N()->__("Can not delete as them  Locked by another user ", $args, 'messages')));
            }
        } else {
            $this->setMessage('NOTICE', array('Select at least one record to delete'));
        }
        if ($userType == "Ess") {
            $this->redirect('training/SummeryTrainRecord?user=Ess');
        } else {
            $this->redirect('training/SummeryTrainRecordAdmin?user=Admin');
        }
    }

    public function executeTraininDirectory(sfWebRequest $request) {

        try {
            $this->culture = $this->getUser()->getCulture();

            $trainRegiService = new TrainingRegisterService();
            $this->trainRegiService = $trainRegiService;

            $this->sorter = new ListSorter('training.sort', 't&d_module', $this->getUser(), array('t.trans_id', ListSorter::ASCENDING));

            $this->sorter->setSort(array($request->getParameter('sort'), $request->getParameter('order')));

//            if ($request->getParameter('mode') == 'search') {
//                if ($request->getParameter('searchMode') != 'all' && trim($request->getParameter('searchValue')) == '') {
//                    $this->setMessage('NOTICE', array('Select the field to search'));
//                    $this->redirect('training/CourseList');
//                }
//            }
            $this->searchMode = ($request->getParameter('searchMode') == '') ? 'all' : $request->getParameter('searchMode');
            $this->searchValue = ($request->getParameter('searchValue') == '') ? '' : $request->getParameter('searchValue');

            $this->sort = ($request->getParameter('sort') == '') ? 't.td_course_id' : $request->getParameter('sort');
            $this->order = ($request->getParameter('order') == '') ? 'ASC' : $request->getParameter('order');

            $res = $trainRegiService->getTrainList($this->searchMode, $this->searchValue, $this->culture, $request->getParameter('page'), $this->sort, $this->order);
            $this->listCourse = $res['data'];


            $this->pglay = $res['pglay'];
            $this->pglay->setTemplate('<a href="{%url}">{%page}</a>');
            $this->pglay->setSelectedTemplate('{%page}');
            if (count($res['data']) <= 0) {
                $this->setMessage('SUCCESS', array($this->getContext()->getI18N()->__("Sorry,Your Search did not Match any Records.", $args, 'messages')));
            }
            
        } catch (sfStopException $sf) {
            
        } catch (Exception $e) {

            $errMsg = new CommonException($e->getMessage(), $e->getCode());
            $this->setMessage('WARNING', $errMsg->display());

            $this->redirect('default/error');
        }
    }

    public function executeTraininPlan(sfWebRequest $request) {
        $encrypt = new EncryptionHandler();
        $this->culture = $this->getUser()->getCulture();
            $instCourseService = new InstituteCourceService();

            $this->instList = $instCourseService->getInstitutelist();

        $instCourseService = new InstituteCourceService();
        $trainRegiService = new TrainingRegisterService();
        $this->Level = $instCourseService->getLevelCombo();

//        if (!strlen($encrypt->decrypt($request->getParameter('id')))) {
//            $this->lockMode = 1;
//        }
        if (strlen($encrypt->decrypt($request->getParameter('id')))) {
            $id = $encrypt->decrypt($request->getParameter('id'));


            try {

                $this->lockMode = $encrypt->decrypt($request->getParameter('lock'));

                if ($this->lockMode == 1) {

                    $conHandler = new ConcurrencyHandler();


                    $recordLocked = $conHandler->setTableLock('hs_hr_td_tarining_plan', array($id), 1);

                    if ($recordLocked) {
                        // Display page in edit mode
                        $this->lockMode = 1;
                    } else {
                        $this->setMessage('WARNING', array($this->getContext()->getI18N()->__('Can not update. Record locked by another user.', $args, 'messages')), false);
                        $this->lockMode = 0;
                    }
                } else if ($this->lockMode == 0) {
                    $conHandler = new ConcurrencyHandler();

                    $recordLocked = $conHandler->resetTableLock('hs_hr_td_tarining_plan', array($id), 1);
                    $this->lockMode = 0;
                }
            } catch (Exception $e) {
                $errMsg = new CommonException($e->getMessage(), $e->getCode());
                $this->setMessage('WARNING', $errMsg->display());
                $this->redirect('training/CourseList');
            }



            $trainingPlan = $trainRegiService->getTPlanIdByID($id);
            $this->trainingPlan = $trainingPlan;
            $partiAssignService = new ParticipateAssignTrainService();        
            $this->currentCourses = $partiAssignService->loadCourseList($trainingPlan->td_inst_id);
        
            $this->lockMode = 1;
        } else {
            $this->lockMode = 0;
            $trainingPlan = new TrainingPlan();
            $this->trainingPlan = $trainingPlan;
        }

        if ($request->isMethod('post')) { 

            try {
                
                if($request->getParameter('txttrnplnid')== null){
                    $trainingPlan = new TrainingPlan();
                }

                if (strlen($request->getParameter('cmbMonth'))) {
                    $Month = $request->getParameter('cmbMonth');
                } else {
                    $Month = null;
                }
                if (strlen($request->getParameter('cmbMonth'))) {
                    $Year = $request->getParameter('cmbYear');
                } else {
                    $Year = null;
                }
                if (strlen($request->getParameter('instName'))) {
                    $InstituteName = $request->getParameter('instName');
                } else {
                    $InstituteName = null;
                }

                if (strlen($request->getParameter('txtTrainingName'))) {
                    $TrainingName = $request->getParameter('txtTrainingName');
                } else {
                    $TrainingName = null;
                }
                if (strlen($request->getParameter('txtTrainingSummary'))) {
                    $TrainingSummary = $request->getParameter('txtTrainingSummary');
                } else {
                    $TrainingSummary = null;
                }
                if (strlen($request->getParameter('txtForWhom'))) {
                    $ForWhom = $request->getParameter('txtForWhom');
                } else {
                    $ForWhom = null;
                }
                if (strlen($request->getParameter('cmbLevel'))) {
                    $trainingPlan->setLevel_code(trim($request->getParameter('cmbLevel')));
                } else {
                    $trainingPlan->setLevel_code(null);
                }
                if (strlen($request->getParameter('txtResoucePerson'))) {
                    $trainingPlan->setTd_plan_resource_person(trim($request->getParameter('txtResoucePerson')));
                } else {
                    $trainingPlan->setTd_plan_resource_person(null);
                }



                $trainingPlan->setTd_plan_month($Month);
                $trainingPlan->setTd_plan_year($Year);
                $trainingPlan->setTd_inst_id($InstituteName);

                $trainingPlan->setTd_course_id($TrainingName);

                $trainingPlan->setTd_plan_training_summery($TrainingSummary);
                $trainingPlan->setTd_plan_training_frowhom($ForWhom);

                $trainRegiService->saveTrainingPlan($trainingPlan);

                $lastId = $trainRegiService->getLastTrainigPlanID();
                $this->lastId = $lastId;
            } catch (Doctrine_Connection_Exception $e) {

                $errMsg = new CommonException($e->getPortableMessage(), $e->getPortableCode());
                $this->setMessage('WARNING', $errMsg->display());
                $this->redirect('training/TraininPlan?id=' . $encrypt->encrypt($lastId[0]['MAX']));
            } catch (Exception $e) {
                $errMsg = new CommonException($e->getMessage(), $e->getCode());
                $this->setMessage('WARNING', $errMsg->display());

                $this->redirect('training/TrainingPlanList');
            }

            if (strlen($trainingPlan->td_plan_id)) {
                $this->setMessage('SUCCESS', array('Successfully Updated'));
                $this->redirect('training/TraininPlan?id=' . $encrypt->encrypt($trainingPlan->td_plan_id));
            } else {
                $this->setMessage('SUCCESS', array('Successfully Added'));
                $this->redirect('training/TrainingPlanList');
            }
        }
    }

    public function executeTrainingPlanList(sfWebRequest $request) {
        try {
            $this->culture = $this->getUser()->getCulture();

            $trainRegiService = new TrainingRegisterService();
            $this->trainRegiService = $trainRegiService;
            
            $this->sorter = new ListSorter('training.sort', 't&d_module', $this->getUser(), array('t.td_plan_id', ListSorter::ASCENDING));

            $this->sorter->setSort(array($request->getParameter('sort'), $request->getParameter('order')));

//            if ($request->getParameter('mode') == 'search') {
//                if ($request->getParameter('searchMode') != 'all' && trim($request->getParameter('searchValue')) == '') {
//                    $this->setMessage('NOTICE', array('Select the field to search'));
//                    $this->redirect('training/CourseList');
//                }
//            }
            $this->searchMode = ($request->getParameter('searchMode') == '') ? 'all' : $request->getParameter('searchMode');
            $this->searchValue = ($request->getParameter('searchValue') == '') ? '' : $request->getParameter('searchValue');

            $this->sort = ($request->getParameter('sort') == '') ? 't.td_plan_id' : $request->getParameter('sort');
            $this->order = ($request->getParameter('order') == '') ? 'ASC' : $request->getParameter('order');

            $res = $trainRegiService->getTrainingPlanList($this->searchMode, $this->searchValue, $this->culture, $request->getParameter('page'), $this->sort, $this->order);
            $this->listMonth = $res['data'];

            $this->pglay = $res['pglay'];
            $this->pglay->setTemplate('<a href="{%url}">{%page}</a>');
            $this->pglay->setSelectedTemplate('{%page}');
            if (count($res['data']) <= 0) {
                $this->setMessage('SUCCESS', array($this->getContext()->getI18N()->__("Sorry,Your Search did not Match any Records.", $args, 'messages')));
            }
            
        } catch (sfStopException $sf) {
            
        } catch (Exception $e) {

            $errMsg = new CommonException($e->getMessage(), $e->getCode());
            $this->setMessage('WARNING', $errMsg->display());

            $this->redirect('default/error');
        }
    }

    public function executeDeleteTrainingPlan(sfWebRequest $request) {

        if (count($request->getParameter('chkLocID')) > 0) {
            
            $trainingDeleteService=new DeleteTrainingService();
            try {
                $conn = Doctrine_Manager::getInstance()->connection();
                $conn->beginTransaction();
                $ids = array();
                $ids = $request->getParameter('chkLocID');
                $countArr = array();
                $saveArr = array();
                for ($i = 0; $i < count($ids); $i++) {
                    $conHandler = new ConcurrencyHandler();
                    $isRecordLocked = $conHandler->isTableLocked('hs_hr_td_tarining_plan', array($ids[$i]), 1);
                    if ($isRecordLocked) {
                        $countArr = $ids[$i];
                    } else {
                        $saveArr = $ids[$i];
                        $trainingDeleteService->deleteTrainingPlan($ids[$i]);
                        $conHandler->resetTableLock('hs_hr_td_tarining_plan', array($ids[$i]), 1);
                    }
                }

                $conn->commit();
            } catch (Doctrine_Connection_Exception $e) {
                $conn->rollBack();
                $errMsg = new CommonException($e->getPortableMessage(), $e->getPortableCode());
                $this->setMessage('WARNING', $errMsg->display());
                $this->redirect('training/TrainingPlanList');
            } catch (Exception $e) {
                $conn->rollBack();
                $errMsg = new CommonException($e->getMessage(), $e->getCode());
                $this->setMessage('WARNING', $errMsg->display());
                $this->redirect('default/error');
            }
            if (count($saveArr) > 0 && count($countArr) == 0) {
                $this->setMessage('SUCCESS', array($this->getContext()->getI18N()->__("Successfully Deleted", $args, 'messages')));
            } elseif (count($saveArr) > 0 && count($countArr) > 0) {
                $this->setMessage('WARNING', array($this->getContext()->getI18N()->__("Some records are can not be deleted as them  Locked by another user ", $args, 'messages')));
            } elseif (count($saveArr) == 0 && count($countArr) > 0) {
                $this->setMessage('WARNING', array($this->getContext()->getI18N()->__("Can not delete as them  Locked by another user ", $args, 'messages')));
            }
        } else {
            $this->setMessage('NOTICE', array('Select at least one record to delete'));
        }
        $this->redirect('training/TrainingPlanList');
    }

    public function executeValidateTrainingCode(sfWebRequest $request) {

        $courseId = $request->getParameter('cId');

        $InstituteCourceService = new InstituteCourceService();

        $count = $InstituteCourceService->getCountofTrainCode($courseId);
        if ($count[0][COUNT] > 0) {
            $msg = "error";
        } else {
            $msg = "ok";
        }


        echo json_encode($msg);
        die;
    }

    public function executeValidateTrainingCodeUpdate(sfWebRequest $request) {

        $courseId = $request->getParameter('cId');
        $currentCode = $request->getParameter('currentCode');
        $InstituteCourceService = new InstituteCourceService();

        $count = $InstituteCourceService->getCountofTrainCodeUpdate($courseId, $currentCode);
        if ($count[0][COUNT] > 0) {
            $msg = "error";
        } else {
            $msg = "ok";
        }


        echo json_encode($msg);
        die;
    }

    public function setMessage($messageType, $message = array(), $persist=true) {
        $this->getUser()->setFlash('messageType', $messageType, $persist);
        $this->getUser()->setFlash('message', $message, $persist);
    }

    public function executeError(sfWebRequest $request) {

        $this->redirect('default/error');
    }

    public function executeAdminappDivSec(sfWebRequest $request) {

        try {
            $this->employee = $_SESSION['empNumber'];

            $this->culture = $this->getUser()->getCulture();
            $InstituteCourceService = new InstituteCourceService();
            $trainApprovalService = new TrainApprovalService();
            $Def_Level = $trainApprovalService->getApproverDef($this->employee);
            $DefLevel = $Def_Level[0]['CompanyStructure'][0]['def_level'];

            $this->InstituteCourceService = $InstituteCourceService;

            $this->sorter = new ListSorter('training.sort', 't&d_module', $this->getUser(), array('t.trans_id', ListSorter::ASCENDING));

            $this->sorter->setSort(array($request->getParameter('sort'), $request->getParameter('order')));

//            if ($request->getParameter('mode') == 'search') {
//                if ($request->getParameter('searchMode') != 'all' && trim($request->getParameter('searchValue')) == '') {
//                    $this->setMessage('NOTICE', array('Select the field to search'));
//                    $this->redirect('Transfer/AdminappDivSec');
//                }
//            }
            $this->searchMode = ($request->getParameter('searchMode') == '') ? 'all' : $request->getParameter('searchMode');
            $this->searchValue = ($request->getParameter('searchValue') == '') ? '' : $request->getParameter('searchValue');

            $this->sort = ($request->getParameter('sort') == '') ? 'e.emp_display_name' : $request->getParameter('sort');
            $this->order = ($request->getParameter('order') == '') ? 'ASC' : $request->getParameter('order');

            $res = $trainApprovalService->getPendingListDivSec($this->searchMode, $this->searchValue, $this->culture, $request->getParameter('page'), $this->sort, $this->order, $DefLevel);
            $this->trainSummeryList = $res['data'];


            $this->pglay = $res['pglay'];
            $this->pglay->setTemplate('<a href="{%url}">{%page}</a>');
            $this->pglay->setSelectedTemplate('{%page}');
            
        } catch (sfStopException $sf) {
            
        } catch (Exception $e) {

            $errMsg = new CommonException($e->getMessage(), $e->getCode());
            $this->setMessage('WARNING', $errMsg->display());

            $this->redirect('default/error');
        }
    }

    public function executeSaveAdminAppDivSec(sfWebRequest $request) {

        $trainApprovalService = new TrainApprovalService();
        $partiAssignService = new ParticipateAssignTrainService();

        $this->InstituteCourceService = $InstituteCourceService;
        $this->employee = $_SESSION['empNumber'];
        $DefLevel = $trainApprovalService->getApproverDef($_SESSION['empNumber']);
        $HeadDiv = $partiAssignService->getDivHeadorApprover($_SESSION['empNumber']);
        $roleAdmin = 6;
        $roleSect = 12;
        $empId = $request->getParameter('empId');
        $Cid = $request->getParameter('cId');
        $status = $request->getParameter('value');
        if ($status != 0) {

            $conn = Doctrine_Manager::getInstance()->connection();
            $conn->beginTransaction();
            $DefLevel = $DefLevel[0]['CompanyStructure'][0]['def_level'];
            if ($DefLevel > 4) {
                $CurStatus = 0;
                $isapproved = 0;
            } else if ($DefLevel > 3) {
                $CurStatus = 1;
                $isapproved = 0;
            } else if ($DefLevel > 2) {
                $CurStatus = 2;
                $isapproved = 0;
            } else if ($DefLevel > 1) {
                $CurStatus = 3;
                $isapproved = 0;
            }
            $ApprSub = $HeadDiv[0]['CompanyStructure'][0]['CompanyStructureDetails'][0]['emp_number'];
            foreach ($HeadDiv[0]['CompanyStructure'][0]['CompanyStructureDetails'] as $row) {

                if ($row['role_group_id'] == $roleAdmin) {
                    $ApprSub = $row['emp_number'];
                }
                if ($row['role_group_id'] == $roleSect) {
                    $ApprHead = $row['emp_number'];
                }
            }
            if ($status == 2) {
                $CurStatus = 6;
            }

            try {
                $trainappDao = new TrainApprovalDao();
                $this->isupdated = $trainappDao->updateAprovelDivSec($empId, $Cid, $status, $CurStatus, $ApprSub, $ApprHead, $isapproved);
                $conn->commit();
            } catch (Doctrine_Connection_Exception $e) {
                $conn->rollBack();
                $errMsg = new CommonException($e->getPortableMessage(), $e->getPortableCode());
                $this->setMessage('WARNING', $errMsg->display());
                $this->redirect('training/AdminappDivSec');
            } catch (Exception $e) {
                $conn->rollBack();
                $errMsg = new CommonException($e->getMessage(), $e->getCode());
                $this->setMessage('WARNING', $errMsg->display());

                $this->redirect('training/AdminappDivSec');
            }
            $this->isupdated = "true";
        } else {
            $this->isupdated = "true";
        }
    }

    public function executeAdminappHRTeam(sfWebRequest $request) {


        try {
            $this->employee = $_SESSION['empNumber'];

            $this->culture = $this->getUser()->getCulture();

            $trainApprovalService = new TrainApprovalService();
            $Def_Level = $trainApprovalService->getApproverDef($this->employee);
            $DefLevel = $Def_Level[0]['CompanyStructure'][0]['def_level'];

            $this->InstituteCourceService = $InstituteCourceService;

            $this->sorter = new ListSorter('training.sort', 't&d_module', $this->getUser(), array('t.trans_id', ListSorter::ASCENDING));

            $this->sorter->setSort(array($request->getParameter('sort'), $request->getParameter('order')));

//            if ($request->getParameter('mode') == 'search') {
//                if ($request->getParameter('searchMode') != 'all' && trim($request->getParameter('searchValue')) == '') {
//                    $this->setMessage('NOTICE', array('Select the field to search'));
//                    $this->redirect('Transfer/AdminappHRTeam');
//                }
//            }
            $this->searchMode = ($request->getParameter('searchMode') == '') ? 'all' : $request->getParameter('searchMode');
            $this->searchValue = ($request->getParameter('searchValue') == '') ? '' : $request->getParameter('searchValue');

            $this->sort = ($request->getParameter('sort') == '') ? 'e.emp_display_name' : $request->getParameter('sort');
            $this->order = ($request->getParameter('order') == '') ? 'ASC' : $request->getParameter('order');

            $res = $trainApprovalService->getPendingListHRTeam($this->searchMode, $this->searchValue, $this->culture, $request->getParameter('page'), $this->sort, $this->order, $DefLevel);
            $this->trainSummeryList = $res['data'];


            $this->pglay = $res['pglay'];
            $this->pglay->setTemplate('<a href="{%url}">{%page}</a>');
            $this->pglay->setSelectedTemplate('{%page}');
            if (count($res['data']) <= 0) {
                $this->setMessage('SUCCESS', array($this->getContext()->getI18N()->__("Sorry,Your Search did not Match any Records.", $args, 'messages')));
            }
            
        } catch (sfStopException $sf) {
            
        } catch (Exception $e) {

            $errMsg = new CommonException($e->getMessage(), $e->getCode());
            $this->setMessage('WARNING', $errMsg->display());

            $this->redirect('default/error');
        }
    }

    public function executeSaveAdminAppHRTeam(sfWebRequest $request) {

        $trainApprovalService = new TrainApprovalService();
        $partiAssignService = new ParticipateAssignTrainService();
        $this->employee = $_SESSION['empNumber'];
        $DefLevel = $trainApprovalService->getApproverDef($_SESSION['empNumber']);
        $HeadDiv = $partiAssignService->getDivHeadorApprover($_SESSION['empNumber']);
        $roleAdmin = 6;
        $roleSect = 12;
        $empId = $request->getParameter('empId');
        $Cid = $request->getParameter('cId');
        $status = $request->getParameter('value');
        if ($status != 0) {


            $conn = Doctrine_Manager::getInstance()->connection();
            $conn->beginTransaction();
            $DefLevel = $DefLevel[0]['CompanyStructure'][0]['def_level'];

            $CurStatus = 3;
            $isapproved = 0;
            $ApprSub = $HeadDiv[0]['CompanyStructure'][0]['CompanyStructureDetails'][0]['emp_number'];

            if ($status == 2) {
                $CurStatus = 6;
            }


            try {

                $this->isupdated = $trainApprovalService->updateAprovelHRTeam($empId, $Cid, $status, $CurStatus, $ApprSub, $ApprHead, $isapproved);
                $conn->commit();
            } catch (Doctrine_Connection_Exception $e) {
                $conn->rollBack();
                $errMsg = new CommonException($e->getPortableMessage(), $e->getPortableCode());
                $this->setMessage('WARNING', $errMsg->display());
                $this->redirect('training/AdminappHRTeam');
            } catch (Exception $e) {
                $conn->rollBack();
                $errMsg = new CommonException($e->getMessage(), $e->getCode());
                $this->setMessage('WARNING', $errMsg->display());

                $this->redirect('training/AdminappHRTeam');
            }
            $this->isupdated = "true";
        } else {
            $this->isupdated = "true";
        }
    }

    public function executeAdminappHRAdmin(sfWebRequest $request) {


        try {
            $this->employee = $_SESSION['empNumber'];

            $this->culture = $this->getUser()->getCulture();
            $InstituteCourceService = new InstituteCourceService();
            $trainApprovalService = new TrainApprovalService();
            $Def_Level = $trainApprovalService->getApproverDef($this->employee);

            $DefLevel = $Def_Level[0]['CompanyStructure'][0]['def_level'];

            $this->InstituteCourceService = $InstituteCourceService;

            $this->sorter = new ListSorter('training.sort', 't&d_module', $this->getUser(), array('t.trans_id', ListSorter::ASCENDING));

            $this->sorter->setSort(array($request->getParameter('sort'), $request->getParameter('order')));

//            if ($request->getParameter('mode') == 'search') {
//                if ($request->getParameter('searchMode') != 'all' && trim($request->getParameter('searchValue')) == '') {
//                    $this->setMessage('NOTICE', array('Select the field to search'));
//                    $this->redirect('Transfer/AdminappHRAdmin');
//                }
//            }
            $this->searchMode = ($request->getParameter('searchMode') == '') ? 'all' : $request->getParameter('searchMode');
            $this->searchValue = ($request->getParameter('searchValue') == '') ? '' : $request->getParameter('searchValue');

            $this->sort = ($request->getParameter('sort') == '') ? 'e.emp_display_name' : $request->getParameter('sort');
            $this->order = ($request->getParameter('order') == '') ? 'ASC' : $request->getParameter('order');

            $res = $trainApprovalService->getPendingListHRAdmin($this->searchMode, $this->searchValue, $this->culture, $request->getParameter('page'), $this->sort, $this->order, $DefLevel);
            $this->trainSummeryList = $res['data'];


            $this->pglay = $res['pglay'];
            $this->pglay->setTemplate('<a href="{%url}">{%page}</a>');
            $this->pglay->setSelectedTemplate('{%page}');
            if (count($res['data']) <= 0) {
                $this->setMessage('SUCCESS', array($this->getContext()->getI18N()->__("Sorry,Your Search did not Match any Records.", $args, 'messages')));
            }
            
        } catch (sfStopException $sf) {
            
        } catch (Exception $e) {

            $errMsg = new CommonException($e->getMessage(), $e->getCode());
            $this->setMessage('WARNING', $errMsg->display());

            $this->redirect('default/error');
        }
    }

    public function executeSaveAdminAppHRAdmin(sfWebRequest $request) {

        $InstituteCourceService = new InstituteCourceService();
        $this->InstituteCourceService = $InstituteCourceService;

        $trainApprovalService = new TrainApprovalService();
        $partiAssignService = new ParticipateAssignTrainService();

        $this->employee = $_SESSION['empNumber'];
        $DefLevel = $trainApprovalService->getApproverDef($_SESSION['empNumber']);
        $HeadDiv = $partiAssignService->getDivHeadorApprover($_SESSION['empNumber']);
        $roleAdmin = 6;
        $roleSect = 12;
        $empId = $request->getParameter('empId');
        $Cid = $request->getParameter('cId');
        $status = $request->getParameter('value');
        if ($status != 0) {


            $conn = Doctrine_Manager::getInstance()->connection();
            $conn->beginTransaction();
            $DefLevel = $DefLevel[0]['CompanyStructure'][0]['def_level'];

            $CurStatus = 4;
            $isapproved = 1;
            $ApprSub = $HeadDiv[0]['CompanyStructure'][0]['CompanyStructureDetails'][0]['emp_number'];

            if ($status == 2) {
                $CurStatus = 6;
            }


            try {

                $this->isupdated = $trainApprovalService->updateAprovelHRTeam($empId, $Cid, $status, $CurStatus, $ApprSub, $ApprHead, $isapproved);
                $conn->commit();
            } catch (Doctrine_Connection_Exception $e) {
                $conn->rollBack();
                $errMsg = new CommonException($e->getPortableMessage(), $e->getPortableCode());
                $this->setMessage('WARNING', $errMsg->display());
                $this->redirect('training/AdminappHRAdmin');
            } catch (Exception $e) {
                $conn->rollBack();
                $errMsg = new CommonException($e->getMessage(), $e->getCode());
                $this->setMessage('WARNING', $errMsg->display());

                $this->redirect('training/AdminappHRAdmin');
            }
            $this->isupdated = "true";
        } else {
            $this->isupdated = "true";
        }
    }


    public function executeTestWokflowStart(sfWebRequest $request) {
        $wfDao = new workflowDao();

        $wfDao->startWorkFlow(2, "8");


        die;
    }

    public function executeAjaxEncryption(sfWebRequest $request) {

        $empId = $request->getParameter('empId');
        $encrypt = new EncryptionHandler();
        echo json_encode($encrypt->encrypt($empId));
        die;
    }

    public function executeSaveWorkFlowApprove(sfWebRequest $request) {
        $this->culture = $this->getUser()->getCulture();
        $encryption = new EncryptionHandler();
        $this->wfID = $encryption->decrypt($request->getParameter('wfID'));
        if (strlen($this->wfID)) {
            $InstituteCourceService = new InstituteCourceService();
            $this->AssignEmployee = $InstituteCourceService->readWFRecord($this->wfID);
        }
    }

    public function executeWorkFlowApprove(sfWebRequest $request) {
        $wfDao = new workflowDao();
        $partiAssignService = new ParticipateAssignTrainService();
        $status = $request->getParameter('hiddenStatus');
        $wfID = $request->getParameter('hiddenWfMainID');
        $Comment = $request->getParameter('txtComment');

        try {
            $InstituteCourceService = new InstituteCourceService();
            $AssignEmployee = $InstituteCourceService->readWFRecord($wfID);
            $conn = Doctrine_Manager::getInstance()->connection();
            $conn->beginTransaction();
            if ($status == 1) {

                $returnWF = $wfDao->approveApplication($wfID, $Comment);
                $WFRecord = $wfDao->getWorkFlowRecord($wfID);


                if ($returnWF == 1) {
                    if ($WFRecord[0][wftype_code] == 3 && $WFRecord[0][wfmain_sequence] == 1) {//die("1Divsec");
                        $AssignEmployee->setTd_asl_status(1);
                    } else if ($WFRecord[0][wftype_code] == 3 && $WFRecord[0][wfmain_sequence] == 2) {//die("1Dissec");
                        $AssignEmployee->setTd_asl_status(2);
                    } else if ($WFRecord[0][wftype_code] == 3 && $WFRecord[0][wfmain_sequence] == 3) {//die("1HRTeam");
                        $AssignEmployee->setTd_asl_status(3);
                    } else if ($WFRecord[0][wftype_code] == 3 && $WFRecord[0][wfmain_sequence] == 4) {//die("1HRAdmin");
                        $AssignEmployee->setTd_asl_status(4);
                    } else if ($WFRecord[0][wftype_code] == 4 && $WFRecord[0][wfmain_sequence] == 1) {//die("2Dissec");
                        $AssignEmployee->setTd_asl_status(2);
                    } else if ($WFRecord[0][wftype_code] == 4 && $WFRecord[0][wfmain_sequence] == 2) {//die("2HRTeam");
                        $AssignEmployee->setTd_asl_status(3);
                    } else if ($WFRecord[0][wftype_code] == 4 && $WFRecord[0][wfmain_sequence] == 3) {//die("2HRAdmin");
                        $AssignEmployee->setTd_asl_status(4);
                    } else if ($WFRecord[0][wftype_code] == 5 && $WFRecord[0][wfmain_sequence] == 1) {//die("3HRTeam");
                        $AssignEmployee->setTd_asl_status(3);
                    } else if ($WFRecord[0][wftype_code] == 5 && $WFRecord[0][wfmain_sequence] == 2) {//die("3HRAdmin");
                        $AssignEmployee->setTd_asl_status(4);
                    } else if ($WFRecord[0][wftype_code] == 6 && $WFRecord[0][wfmain_sequence] == 1) {//die("4HRAdmin");
                        $AssignEmployee->setTd_asl_status(4);
                    }
                    $partiAssignService->saveAssignList($AssignEmployee);
                    $conn->commit();
                    $this->setMessage('SUCCESS', array('Successfully Approved'));
                    $this->redirect('workflow/ApprovalSummary');
                } else {
                    $this->setMessage('WARNING', array('Not Approved'));
                    $this->redirect('workflow/ApprovalSummary');
                }
            } else {
                $returnRWF = $wfDao->directApprovalReject($wfID, $Comment);
                if ($returnRWF == 1) {

                    if ($WFRecord[0][wftype_code] == 3 && $WFRecord[0][wfmain_sequence] == 1) {
                        $AssignEmployee->setTd_asl_status(1);
                    } else if ($WFRecord[0][wftype_code] == 3 && $WFRecord[0][wfmain_sequence] == 2) {
                        $AssignEmployee->setTd_asl_status(2);
                    } else if ($WFRecord[0][wftype_code] == 3 && $WFRecord[0][wfmain_sequence] == 3) {
                        $AssignEmployee->setTd_asl_status(3);
                    } else if ($WFRecord[0][wftype_code] == 3 && $WFRecord[0][wfmain_sequence] == 4) {
                        $AssignEmployee->setTd_asl_status(4);
                    } else if ($WFRecord[0][wftype_code] == 4 && $WFRecord[0][wfmain_sequence] == 1) {
                        $AssignEmployee->setTd_asl_status(2);
                    } else if ($WFRecord[0][wftype_code] == 4 && $WFRecord[0][wfmain_sequence] == 2) {
                        $AssignEmployee->setTd_asl_status(3);
                    } else if ($WFRecord[0][wftype_code] == 4 && $WFRecord[0][wfmain_sequence] == 3) {
                        $AssignEmployee->setTd_asl_status(4);
                    } else if ($WFRecord[0][wftype_code] == 5 && $WFRecord[0][wfmain_sequence] == 1) {
                        $AssignEmployee->setTd_asl_status(3);
                    } else if ($WFRecord[0][wftype_code] == 5 && $WFRecord[0][wfmain_sequence] == 2) {
                        $AssignEmployee->setTd_asl_status(4);
                    } else if ($WFRecord[0][wftype_code] == 6 && $WFRecord[0][wfmain_sequence] == 1) {
                        $AssignEmployee->setTd_asl_status(4);
                    }
                    $partiAssignService->saveAssignList($AssignEmployee);
                    $conn->commit();
                    $this->setMessage('SUCCESS', array('Successfully Rejected'));
                    $this->redirect('workflow/ApprovalSummary');
                } else {
                    $this->setMessage('WARNING', array('Not Rejected'));
                    $this->redirect('workflow/ApprovalSummary');
                }
            }
        } catch (sfStopException $e) {
            
        } catch (Doctrine_Connection_Exception $e) {
            $conn->rollback();
            $errMsg = new CommonException($e->getPortableMessage(), $e->getPortableCode());
            $this->setMessage('WARNING', $errMsg->display());
            $this->redirect('workflow/ApprovalSummary');
        } catch (Exception $e) {
            $conn->rollback();
            $errMsg = new CommonException($e->getMessage(), $e->getCode());
            $this->setMessage('WARNING', $errMsg->display());

            $this->redirect('workflow/ApprovalSummary');
        }
        die;
    }
    
    public function executeCalander(sfWebRequest $request) {
        $this->culture = $this->getUser()->getCulture();
        $TrainingRegisterService = new TrainingRegisterService();
        $this->courseList=$TrainingRegisterService->readCourse();
    }

}
