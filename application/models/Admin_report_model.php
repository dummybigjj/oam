<?php
class Admin_report_model extends CI_Model {

    public function __construct(){
		parent::__construct();
		$this->load->model('crud');
	}

    /**
     * generateStudentsAttendanceXlsx function.
     * 
     * @access public
     * @param associative array $attendance
     * @param associative array $att_record
     * @param associative array $att_dates
     * @param date $range1
     * @param date $range2
     * @return xlsx|xlx file on success.
     */
    public function generateStudentsAttendanceXlsx($attendance=array(),$att_record=array(),$att_dates=array(),$range1,$range2,$cond){
        //activate worksheet number 1
        $this->excel->setActiveSheetIndex(0);
        //name the worksheet
        $this->excel->getActiveSheet()->setTitle('Students Daily Attendance');
        //set cell D2 content with some text
        $this->excel->getActiveSheet()->setCellValue('D2', 'TECHNICAL HIGHER INSTITUTE FOR ENGINEERING AND PETROLEUM');
        //make the font become bold
        $this->excel->getActiveSheet()->getStyle('D2')->getFont()->setBold(true);
        //merge cell D2 until M2
        $this->excel->getActiveSheet()->mergeCells('D2:M2');
        //set aligment to center for that merged cell (D2 to M2)
        $this->excel->getActiveSheet()->getStyle('D2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

        if(array_key_exists('`student`.`company`', $cond)):
        //set cell D3 content with some text
        $this->excel->getActiveSheet()->setCellValue('D3', 'Students Daily Attendance Report '.$cond['`student`.`company`']);
        else:
        $this->excel->getActiveSheet()->setCellValue('D3', 'Students Daily Attendance Report');
        endif;
        //merge cell D3 until M3
        $this->excel->getActiveSheet()->mergeCells('D3:M3');
        //set aligment to center for that merged cell (D3 to M3)
        $this->excel->getActiveSheet()->getStyle('D3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

        //set cell D4 content with some text
        $this->excel->getActiveSheet()->setCellValue('D4', 'Report Date Range: '.date('F d, Y',strtotime($range1)).' - '.date('F d, Y',strtotime($range2)));
        //merge cell D4 until M4
        $this->excel->getActiveSheet()->mergeCells('D4:M4');
        //set aligment to center for that merged cell (D4 to M4)
        $this->excel->getActiveSheet()->getStyle('D4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        
        // set column header names
        $fields = array();
        // set custom colum names
        $fields = array('','STUDENT NO','STUDENT NAME');
        for ($i=0; $i < count($att_dates); $i++) { 
            $date_col = preg_split("/(\W+)/", $att_dates[$i]['attendance_date']);
            $fields[] = $date_col[1]."/".$date_col[2];
        }
        $fields[] = 'P';
        $fields[] = 'A';
        $fields[] = 'L';
        $fields[] = 'E';
        $fields[] = 'V';
        $fields[] = 'SCORES';
        // set column header names to active sheet
        $this->excel->getActiveSheet()->fromArray($fields, NULL, 'A7');
        $target_cell = 8;
        // set report value
        for ($i=0; $i < count($att_record); $i++) { 
            $lineData = array('',$att_record[$i]['student_no'],$att_record[$i]['arabic_name']);
            for ($b=0; $b < count($att_dates); $b++) { 
                $is_found = FALSE;
                for ($a=0; $a < count($attendance); $a++) { 
                    if($attendance[$a]['attendance_date']==$att_dates[$b]['attendance_date'] && $att_record[$i]['student_id']==$attendance[$a]['student_id']){
                        $lineData[] = $attendance[$a]['attendance'];
                        $is_found = TRUE;
                    }
                }
                if($is_found===FALSE){
                    $lineData[$b+3] = "";
                }
            }
            $lineData[] = $att_record[$i]['presents'];
            $lineData[] = $att_record[$i]['absences'];
            $lineData[] = $att_record[$i]['lates'];
            $lineData[] = $att_record[$i]['excuses'];
            $lineData[] = $att_record[$i]['vacations'];
            $lineData[] = $att_record[$i]['points'];
            // set report value to active sheet
            $this->excel->getActiveSheet()->fromArray($lineData, NULL, 'A'.$target_cell);
            $target_cell++;
        }

        //set singed footer
        $this->excel->getActiveSheet()->setCellValue('C'.($target_cell+5), 'Verified and Assessed by:');
        $this->excel->getActiveSheet()->getStyle('C'.($target_cell+5))->getFont()->setBold(true);
        $this->excel->getActiveSheet()->setCellValue('C'.($target_cell+7), 'Mustafa Hassan Al Sulayyil');
        $this->excel->getActiveSheet()->getStyle('C'.($target_cell+7))->getFont()->setBold(true);
        $this->excel->getActiveSheet()->setCellValue('C'.($target_cell+8), 'Registrar');
        $this->excel->getActiveSheet()->getStyle('C'.($target_cell+8))->getFont()->setBold(true);
        $this->excel->getActiveSheet()->setCellValue('C'.($target_cell+9), 'Date: '.date('m/d/Y'));
        $this->excel->getActiveSheet()->getStyle('C'.($target_cell+9))->getFont()->setBold(true);

        // set column to auto sized
        $this->excel->getActiveSheet()->getColumnDimension('B')->setAutoSize(TRUE);
        $this->excel->getActiveSheet()->getColumnDimension('C')->setAutoSize(TRUE);

        // set filename
        $filename = 'THIEP-STUDENTS-DAILY-ATTENDANCE-REPORT-'.date('Y-m-d').'.xlsx';
        // header('Content-Type: application/vnd.ms-excel'); //mime type
        // Redirect output to a client’s web browser (Excel2007)
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="'.$filename.'"'); //tell browser what's the file name
        // If you're serving to IE 9, then the following may be needed
        header('Cache-Control: max-age=1');
        // If you're serving to IE over SSL, then the following may be needed
        header ('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
        header ('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT'); // always modified
        header ('Cache-Control: cache, must-revalidate'); // HTTP/1.1
        header ('Pragma: public'); // HTTP/1.0
                    
        //save it to Excel5 format (excel 2003 .XLS file), change this to 'Excel2007' (and adjust the filename extension, also the header mime type)
        //if you want to save it as .XLSX Excel 2007 format
        $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel2007');  
        //force user to download the Excel file without writing it to server's HD
        return $objWriter->save('php://output');
    }

    /**
     * generateStudentAttendanceByVocationalProgramCsv function.
     * 
     * @access public
     * @param associative array $attendance
     * @param associative array $att_record
     * @param associative array $att_dates
     * @param associative array $voc_program
     * @param date $range1
     * @param date $range2
     * @return csv file on success.
     */
    public function generateStudentAttendanceByVocationalProgramCsv($attendance=array(),$att_record=array(),$att_dates=array(),$voc_program=array(),$range1,$range2,$cond){
        //activate worksheet number 1
        $this->excel->setActiveSheetIndex(0);
        //name the worksheet
        $this->excel->getActiveSheet()->setTitle($voc_program['voc_program']);
        //set cell D2 content with some text
        $this->excel->getActiveSheet()->setCellValue('D2', 'TECHNICAL HIGHER INSTITUTE FOR ENGINEERING AND PETROLEUM');
        //make the font become bold
        $this->excel->getActiveSheet()->getStyle('D2')->getFont()->setBold(true);
        //merge cell D2 until M2
        $this->excel->getActiveSheet()->mergeCells('D2:M2');
        //set aligment to center for that merged cell (D2 to M2)
        $this->excel->getActiveSheet()->getStyle('D2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

        if(array_key_exists('`student`.`company`', $cond)):
        //set cell D3 content with some text
        $this->excel->getActiveSheet()->setCellValue('D3', 'Attendance Report '.$cond['`student`.`company`']);
        else:
        $this->excel->getActiveSheet()->setCellValue('D3', 'Attendance Report');
        endif;
        //merge cell D3 until M3
        $this->excel->getActiveSheet()->mergeCells('D3:M3');
        //set aligment to center for that merged cell (D3 to M3)
        $this->excel->getActiveSheet()->getStyle('D3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

        //set cell D4 content with some text
        $this->excel->getActiveSheet()->setCellValue('D4', 'Vocational Program: '.$voc_program['voc_program'].' ('.$voc_program['voc_program_acronym'].')');
        //merge cell D4 until M4
        $this->excel->getActiveSheet()->mergeCells('D4:M4');
        //set aligment to center for that merged cell (D4 to M4)
        $this->excel->getActiveSheet()->getStyle('D4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

        //set cell D5 content with some text
        $this->excel->getActiveSheet()->setCellValue('D5', 'Report Date Range: '.date('F d, Y',strtotime($range1)).' - '.date('F d, Y',strtotime($range2)));
        //merge cell D5 until M5
        $this->excel->getActiveSheet()->mergeCells('D5:M5');
        //set aligment to center for that merged cell (D5 to M5)
        $this->excel->getActiveSheet()->getStyle('D5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        
        // set column header names
        $fields = array();
        // set custom colum names
        $fields = array('','STUDENT NO','STUDENT NAME');
        for ($i=0; $i < count($att_dates); $i++) { 
            $date_col = preg_split("/(\W+)/", $att_dates[$i]['attendance_date']);
            $fields[] = $date_col[1]."/".$date_col[2];
        }
        $fields[] = 'P';
        $fields[] = 'A';
        $fields[] = 'L';
        $fields[] = 'E';
        $fields[] = 'V';
        $fields[] = 'SCORES';
        $fields[] = 'DAYS PRESENT';

        // set column header names to active sheet
        $this->excel->getActiveSheet()->fromArray($fields, NULL, 'A7');
        $target_cell = 8;
        // set report value
        for ($i=0; $i < count($att_record); $i++) { 
            $lineData = array('',$att_record[$i]['student_no'],$att_record[$i]['arabic_name']);
            for ($b=0; $b < count($att_dates); $b++) { 
                $is_found = FALSE;
                for ($a=0; $a < count($attendance); $a++) { 
                    if($attendance[$a]['attendance_date']==$att_dates[$b]['attendance_date'] && $att_record[$i]['student_id']==$attendance[$a]['student_id']){
                        $lineData[] = $attendance[$a]['attendance'];
                        $is_found = TRUE;
                    }
                }
                if($is_found===FALSE){
                    $lineData[$b+3] = "";
                }
            }
            $lineData[] = $att_record[$i]['presents'];
            $lineData[] = $att_record[$i]['absences'];
            $lineData[] = $att_record[$i]['lates'];
            $lineData[] = $att_record[$i]['excuses'];
            $lineData[] = $att_record[$i]['vacations'];
            $lineData[] = $att_record[$i]['points'];
            $lineData[] = $att_record[$i]['present_days'];
            // set report value to active sheet
            $this->excel->getActiveSheet()->fromArray($lineData, NULL, 'A'.$target_cell);
            $target_cell++;
        }

        //set singed footer
        $this->excel->getActiveSheet()->setCellValue('C'.($target_cell+5), 'Verified and Assessed by:');
        $this->excel->getActiveSheet()->getStyle('C'.($target_cell+5))->getFont()->setBold(true);
        $this->excel->getActiveSheet()->setCellValue('C'.($target_cell+7), 'Mustafa Hassan Al Sulayyil');
        $this->excel->getActiveSheet()->getStyle('C'.($target_cell+7))->getFont()->setBold(true);
        $this->excel->getActiveSheet()->setCellValue('C'.($target_cell+8), 'Registrar');
        $this->excel->getActiveSheet()->getStyle('C'.($target_cell+8))->getFont()->setBold(true);
        $this->excel->getActiveSheet()->setCellValue('C'.($target_cell+9), 'Date: '.date('m/d/Y'));
        $this->excel->getActiveSheet()->getStyle('C'.($target_cell+9))->getFont()->setBold(true);

        // set column to auto sized
        $this->excel->getActiveSheet()->getColumnDimension('B')->setAutoSize(TRUE);
        $this->excel->getActiveSheet()->getColumnDimension('C')->setAutoSize(TRUE);

        // set filename
        $filename = "THIEP-".$voc_program['voc_program']."-ATTENDANCE-REPORT-".date('Y-m-d').".xlsx";
        // header('Content-Type: application/vnd.ms-excel'); //mime type
        // Redirect output to a client’s web browser (Excel2007)
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="'.$filename.'"'); //tell browser what's the file name
        // If you're serving to IE 9, then the following may be needed
        header('Cache-Control: max-age=1');
        // If you're serving to IE over SSL, then the following may be needed
        header ('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
        header ('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT'); // always modified
        header ('Cache-Control: cache, must-revalidate'); // HTTP/1.1
        header ('Pragma: public'); // HTTP/1.0
                    
        //save it to Excel5 format (excel 2003 .XLS file), change this to 'Excel2007' (and adjust the filename extension, also the header mime type)
        //if you want to save it as .XLSX Excel 2007 format
        $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel2007');  
        //force user to download the Excel file without writing it to server's HD
        return $objWriter->save('php://output');
    }

    /**
     * generateStudentAttendanceBySubjectCodeCsv function.
     * 
     * @access public
     * @param associative array $attendance
     * @param associative array $att_record
     * @param associative array $att_dates
     * @param associative array $con
     * @param date $range1
     * @param date $range2
     * @return csv file on success.
     */
    public function generateStudentAttendanceBySubjectCodeCsv($attendance=array(),$att_record=array(),$att_dates=array(),$con=array(),$range1,$range2,$cond){
        //activate worksheet number 1
        $this->excel->setActiveSheetIndex(0);
        //name the worksheet
        $this->excel->getActiveSheet()->setTitle($con['subject_code']);
        //set cell D2 content with some text
        $this->excel->getActiveSheet()->setCellValue('D2', 'TECHNICAL HIGHER INSTITUTE FOR ENGINEERING AND PETROLEUM');
        //make the font become bold
        $this->excel->getActiveSheet()->getStyle('D2')->getFont()->setBold(true);
        //merge cell D2 until M2
        $this->excel->getActiveSheet()->mergeCells('D2:M2');
        //set aligment to center for that merged cell (D2 to M2)
        $this->excel->getActiveSheet()->getStyle('D2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

        if(array_key_exists('`student`.`company`', $cond)):
        //set cell D3 content with some text
        $this->excel->getActiveSheet()->setCellValue('D3', 'Attendance Report '.$cond['`student`.`company`']);
        else:
        $this->excel->getActiveSheet()->setCellValue('D3', 'Attendance Report');
        endif;
        //merge cell D3 until M3
        $this->excel->getActiveSheet()->mergeCells('D3:M3');
        //set aligment to center for that merged cell (D3 to M3)
        $this->excel->getActiveSheet()->getStyle('D3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

        //set cell D4 content with some text
        $this->excel->getActiveSheet()->setCellValue('D4', 'Subject Code: '.$con['subject_code']);
        //merge cell D4 until M4
        $this->excel->getActiveSheet()->mergeCells('D4:M4');
        //set aligment to center for that merged cell (D4 to M4)
        $this->excel->getActiveSheet()->getStyle('D4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

        //set cell D5 content with some text
        $this->excel->getActiveSheet()->setCellValue('D5', 'Report Date Range: '.date('F d, Y',strtotime($range1)).' - '.date('F d, Y',strtotime($range2)));
        //merge cell D5 until M5
        $this->excel->getActiveSheet()->mergeCells('D5:M5');
        //set aligment to center for that merged cell (D5 to M5)
        $this->excel->getActiveSheet()->getStyle('D5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        
        // set column header names
        $fields = array();
        // set custom colum names
        $fields = array('','STUDENT NO','STUDENT NAME');
        for ($i=0; $i < count($att_dates); $i++) { 
            $date_col = preg_split("/(\W+)/", $att_dates[$i]['attendance_date']);
            $fields[] = $date_col[1]."/".$date_col[2];
        }
        $fields[] = 'P';
        $fields[] = 'A';
        $fields[] = 'L';
        $fields[] = 'E';
        $fields[] = 'V';
        $fields[] = 'SCORES';
        $fields[] = 'DAYS PRESENT';

        // set column header names to active sheet
        $this->excel->getActiveSheet()->fromArray($fields, NULL, 'A7');
        $target_cell = 8;
        // set report value
        for ($i=0; $i < count($att_record); $i++) { 
            $lineData = array('',$att_record[$i]['student_no'],$att_record[$i]['arabic_name']);
            for ($b=0; $b < count($att_dates); $b++) { 
                $is_found = FALSE;
                for ($a=0; $a < count($attendance); $a++) { 
                    if($attendance[$a]['attendance_date']==$att_dates[$b]['attendance_date'] && $att_record[$i]['student_id']==$attendance[$a]['student_id']){
                        $lineData[] = $attendance[$a]['attendance'];
                        $is_found = TRUE;
                    }
                }
                if($is_found===FALSE){
                    $lineData[$b+3] = "";
                }
            }
            $lineData[] = $att_record[$i]['presents'];
            $lineData[] = $att_record[$i]['absences'];
            $lineData[] = $att_record[$i]['lates'];
            $lineData[] = $att_record[$i]['excuses'];
            $lineData[] = $att_record[$i]['vacations'];
            $lineData[] = $att_record[$i]['points'];
            $lineData[] = $att_record[$i]['present_days'];
            // set report value to active sheet
            $this->excel->getActiveSheet()->fromArray($lineData, NULL, 'A'.$target_cell);
            $target_cell++;
        }

        //set singed footer
        $this->excel->getActiveSheet()->setCellValue('C'.($target_cell+5), 'Verified and Assessed by:');
        $this->excel->getActiveSheet()->getStyle('C'.($target_cell+5))->getFont()->setBold(true);
        $this->excel->getActiveSheet()->setCellValue('C'.($target_cell+7), 'Mustafa Hassan Al Sulayyil');
        $this->excel->getActiveSheet()->getStyle('C'.($target_cell+7))->getFont()->setBold(true);
        $this->excel->getActiveSheet()->setCellValue('C'.($target_cell+8), 'Registrar');
        $this->excel->getActiveSheet()->getStyle('C'.($target_cell+8))->getFont()->setBold(true);
        $this->excel->getActiveSheet()->setCellValue('C'.($target_cell+9), 'Date: '.date('m/d/Y'));
        $this->excel->getActiveSheet()->getStyle('C'.($target_cell+9))->getFont()->setBold(true);

        // set column to auto sized
        $this->excel->getActiveSheet()->getColumnDimension('B')->setAutoSize(TRUE);
        $this->excel->getActiveSheet()->getColumnDimension('C')->setAutoSize(TRUE);
        $this->excel->getActiveSheet()->getColumnDimension('M')->setAutoSize(TRUE);

        // set filename
        $filename = "THIEP-".$con['subject_code']."-ATTENDANCE-REPORT-".date('Y-m-d').".xlsx";
        // header('Content-Type: application/vnd.ms-excel'); //mime type
        // Redirect output to a client’s web browser (Excel2007)
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="'.$filename.'"'); //tell browser what's the file name
        // If you're serving to IE 9, then the following may be needed
        header('Cache-Control: max-age=1');
        // If you're serving to IE over SSL, then the following may be needed
        header ('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
        header ('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT'); // always modified
        header ('Cache-Control: cache, must-revalidate'); // HTTP/1.1
        header ('Pragma: public'); // HTTP/1.0
                    
        //save it to Excel5 format (excel 2003 .XLS file), change this to 'Excel2007' (and adjust the filename extension, also the header mime type)
        //if you want to save it as .XLSX Excel 2007 format
        $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel2007');  
        //force user to download the Excel file without writing it to server's HD
        return $objWriter->save('php://output');
    }

    /**
     * generateStudentRemarksReportBySubjectCodeCsv function.
     * 
     * @access public
     * @param associative array $attendance
     * @param associative array $att_record
     * @param associative array $att_dates
     * @param associative array $con
     * @param date $range1
     * @param date $range2
     * @return csv file on success.
     */
    public function generateStudentRemarksReportBySubjectCodeCsv($attendance=array(),$att_record=array(),$att_dates=array(),$con=array(),$range1,$range2){
        //activate worksheet number 1
        $this->excel->setActiveSheetIndex(0);
        //name the worksheet
        $this->excel->getActiveSheet()->setTitle($con['subject_code']);
        //set cell D2 content with some text
        $this->excel->getActiveSheet()->setCellValue('D2', 'TECHNICAL HIGHER INSTITUTE FOR ENGINEERING AND PETROLEUM');
        //make the font become bold
        $this->excel->getActiveSheet()->getStyle('D2')->getFont()->setBold(true);
        //merge cell D2 until M2
        $this->excel->getActiveSheet()->mergeCells('D2:M2');
        //set aligment to center for that merged cell (D2 to M2)
        $this->excel->getActiveSheet()->getStyle('D2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

        //set cell D3 content with some text
        $this->excel->getActiveSheet()->setCellValue('D3', 'Remarks Report');
        //merge cell D3 until M3
        $this->excel->getActiveSheet()->mergeCells('D3:M3');
        //set aligment to center for that merged cell (D3 to M3)
        $this->excel->getActiveSheet()->getStyle('D3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

        //set cell D4 content with some text
        $this->excel->getActiveSheet()->setCellValue('D4', 'Subject Code: '.$con['subject_code']);
        //merge cell D4 until M4
        $this->excel->getActiveSheet()->mergeCells('D4:M4');
        //set aligment to center for that merged cell (D4 to M4)
        $this->excel->getActiveSheet()->getStyle('D4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

        //set cell D5 content with some text
        $this->excel->getActiveSheet()->setCellValue('D5', 'Report Date Range: '.date('F d, Y',strtotime($range1)).' - '.date('F d, Y',strtotime($range2)));
        //merge cell D5 until M5
        $this->excel->getActiveSheet()->mergeCells('D5:M5');
        //set aligment to center for that merged cell (D5 to M5)
        $this->excel->getActiveSheet()->getStyle('D5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        
        // set column header names
        $fields = array();
        // set custom colum names
        $fields = array('','STUDENT NO','STUDENT NAME');
        for ($i=0; $i < count($att_dates); $i++) { 
            $date_col = preg_split("/(\W+)/", $att_dates[$i]['attendance_date']);
            $fields[] = $date_col[1]."/".$date_col[2];
        }

        // set column header names to active sheet
        $this->excel->getActiveSheet()->fromArray($fields, NULL, 'A7');
        $target_cell = 8;
        // set report value
        for ($i=0; $i < count($att_record); $i++) { 
            $lineData = array('',$att_record[$i]['student_no'],$att_record[$i]['arabic_name']);
            for ($b=0; $b < count($att_dates); $b++) { 
                $is_found = FALSE;
                for ($a=0; $a < count($attendance); $a++) { 
                    if($attendance[$a]['attendance_date']==$att_dates[$b]['attendance_date'] && $att_record[$i]['student_id']==$attendance[$a]['student_id']){
                        $lineData[] = $attendance[$a]['remarks'];
                        $is_found = TRUE;
                    }
                }
                if($is_found===FALSE){
                    $lineData[$b+3] = "";
                }
            }
            // set report value to active sheet
            $this->excel->getActiveSheet()->fromArray($lineData, NULL, 'A'.$target_cell);
            $target_cell++;
        }

        //set singed footer
        $this->excel->getActiveSheet()->setCellValue('C'.($target_cell+5), 'Verified and Assessed by:');
        $this->excel->getActiveSheet()->getStyle('C'.($target_cell+5))->getFont()->setBold(true);
        $this->excel->getActiveSheet()->setCellValue('C'.($target_cell+7), 'Mustafa Hassan Al Sulayyil');
        $this->excel->getActiveSheet()->getStyle('C'.($target_cell+7))->getFont()->setBold(true);
        $this->excel->getActiveSheet()->setCellValue('C'.($target_cell+8), 'Registrar');
        $this->excel->getActiveSheet()->getStyle('C'.($target_cell+8))->getFont()->setBold(true);
        $this->excel->getActiveSheet()->setCellValue('C'.($target_cell+9), 'Date: '.date('m/d/Y'));
        $this->excel->getActiveSheet()->getStyle('C'.($target_cell+9))->getFont()->setBold(true);

        // set column to auto sized
        $this->excel->getActiveSheet()->getColumnDimension('B')->setAutoSize(TRUE);
        $this->excel->getActiveSheet()->getColumnDimension('C')->setAutoSize(TRUE);
        // $this->excel->getActiveSheet()->getColumnDimension('M')->setAutoSize(TRUE);

        // set filename
        $filename = "THIEP-".$con['subject_code']."-REMARKS-REPORT-".date('Y-m-d').".xlsx";
        // header('Content-Type: application/vnd.ms-excel'); //mime type
        // Redirect output to a client’s web browser (Excel2007)
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="'.$filename.'"'); //tell browser what's the file name
        // If you're serving to IE 9, then the following may be needed
        header('Cache-Control: max-age=1');
        // If you're serving to IE over SSL, then the following may be needed
        header ('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
        header ('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT'); // always modified
        header ('Cache-Control: cache, must-revalidate'); // HTTP/1.1
        header ('Pragma: public'); // HTTP/1.0
                    
        //save it to Excel5 format (excel 2003 .XLS file), change this to 'Excel2007' (and adjust the filename extension, also the header mime type)
        //if you want to save it as .XLSX Excel 2007 format
        $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel2007');  
        //force user to download the Excel file without writing it to server's HD
        return $objWriter->save('php://output');
    }

	/**
	 * generateVocProgramEnlistmentReportCsv function.
	 * 
	 * @access public
	 * @param associative array $voc_program
	 * @param associative array $students
	 * @return csv file on success.
	 */
	public function generateVocProgramEnlistmentReportCsv($voc_program = array(),$students = array()){
		// file name 
        $delimiter = ",";
        $filename = "THIEP-".$voc_program['voc_program_acronym']."-ENLISTMENT-REPORT-".date('Y-m-d').".csv";
        
        //create a file pointer
        $f = fopen('php://memory', 'w');

        $fields = array();
        fputcsv($f, $fields, $delimiter);
        //set report basic info
        $fields = array('','ENLISTMENT REPORT', 'TECHNICAL HIGHER INSTITUTE FOR ENGINEERING AND PETROLEUM');
        fputcsv($f, $fields, $delimiter);
        $fields = array('','VOCATIONAL PROGRAM', $voc_program['voc_program'].' - '.$voc_program['voc_program_acronym']);
        fputcsv($f, $fields, $delimiter);
        
        //set column headers
        $fields = array();
        fputcsv($f, $fields, $delimiter);
        $fields = array('', 'ES', 'STUDENT NO.', 'STUDENT NAME');
        fputcsv($f, $fields, $delimiter);
        $ctr = 1;
        for ($i=0; $i < count($students); $i++) { 
            $lineData = array('',$ctr,$students[$i]['student_no'],$students[$i]['arabic_name']);
            fputcsv($f, $lineData, $delimiter);
            $ctr++;
        }

        //move back to beginning of file
        fseek($f, 0);
        
        //set headers to download file rather than displayed
        header('Content-Type: text/csv');
        header('Content-Disposition: attachment; filename="' . $filename . '";');
        
        //output all remaining data on a file pointer
        return fpassthru($f);
	}

	/**
	 * generateSubjectCodeEnlistmnentReportCsv function.
	 * 
	 * @access public
	 * @param associative array $students
	 * @param associative array $condition
	 * @return csv file on success.
	 */
	public function generateSubjectCodeEnlistmnentReportCsv($students = array(),$condition = array()){
		// file name 
        $delimiter = ",";
        $filename = "THIEP-".$condition['subject_code']."-ENLISTMENT-REPORT-".date('Y-m-d').".csv";
        
        //create a file pointer
        $f = fopen('php://memory', 'w');

        $fields = array();
        fputcsv($f, $fields, $delimiter);
        //set report basic info
        $fields = array('','ENLISTMENT REPORT', 'TECHNICAL HIGHER INSTITUTE FOR ENGINEERING AND PETROLEUM');
        fputcsv($f, $fields, $delimiter);
        $fields = array('','SUBJECT CODE: ', $condition['subject_code']);
        fputcsv($f, $fields, $delimiter);
        
        //set column headers
        $fields = array();
        fputcsv($f, $fields, $delimiter);
        $fields = array('','ES', 'STUDENT NO.', 'STUDENT NAME');
        fputcsv($f, $fields, $delimiter);
        $ctr = 1;
        for ($i=0; $i < count($students); $i++) { 
            $lineData = array('',$ctr,$students[$i]['student_no'],$students[$i]['arabic_name']);
            fputcsv($f, $lineData, $delimiter);
            $ctr++;
        }

        //move back to beginning of file
        fseek($f, 0);
        
        //set headers to download file rather than displayed
        header('Content-Type: text/csv');
        header('Content-Disposition: attachment; filename="' . $filename . '";');
        
        //output all remaining data on a file pointer
        return fpassthru($f);
	}

	// /**
	//  * generateVocProgramAttendanceReportPdf function.
	//  * 
	//  * @access public
	//  * @param associative array $attendance
	//  * @param associative array $voc_program
	//  * @param date $range1
	//  * @param date $range2
	//  * @return pdf file on success.
	//  */
	// public function generateVocProgramAttendanceReportPdf($attendance = array(),$voc_program = array(),$range1,$range2){
	// 	//============================================================+
 //        // File name   : example_001.php
 //        // Begin       : 2008-03-04
 //        // Last Update : 2013-05-14
 //        //
 //        // Description : Example 001 for TCPDF class
 //        //               Default Header and Footer
 //        //
 //        // Author: Nicola Asuni
 //        //
 //        // (c) Copyright:
 //        //               Nicola Asuni
 //        //               Tecnick.com LTD
 //        //               www.tecnick.com
 //        //               info@tecnick.com
 //        //============================================================+
     
 //        /**
 //        * Creates an example PDF TEST document using TCPDF
 //        * @package com.tecnick.tcpdf
 //        * @abstract TCPDF - Example: Default Header and Footer
 //        * @author Nicola Asuni
 //        * @since 2008-03-04
 //        */
     
 //        // create new PDF document
 //        $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);    
     
 //        // set document information
 //        // $pdf->SetCreator(PDF_CREATOR);
 //        // $pdf->SetAuthor('Nicola Asuni');
 //        // $pdf->SetTitle('TCPDF Example 001');
 //        // $pdf->SetSubject('TCPDF Tutorial');
 //        // $pdf->SetKeywords('TCPDF, PDF, example, test, guide');   
     
 //        // set default header data
 //        // $pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE.' 001', PDF_HEADER_STRING, array(0,64,255), array(0,64,128));
 //        // $pdf->setFooterData(array(0,64,0), array(0,64,128)); 
     
 //        // set header and footer fonts
 //        // $pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
 //        // $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));  
     
 //        // set default monospaced font
 //        $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED); 
     
 //        // set margins
 //        // $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
 //        // $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
 //        // $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);    
     
 //        // set auto page breaks
 //        $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM); 
     
 //        // set image scale factor
 //        $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);  
     
 //        // set some language-dependent strings (optional)
 //        if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
 //            require_once(dirname(__FILE__).'/lang/eng.php');
 //            $pdf->setLanguageArray($l);
 //        }   
     
 //        // ---------------------------------------------------------    
     
 //        // set default font subsetting mode
 //        $pdf->setFontSubsetting(true);   
     
 //        // Set font
 //        // dejavusans is a UTF-8 Unicode font, if you only need to
 //        // print standard ASCII chars, you can use core fonts like
 //        // helvetica or times to reduce file size.
 //        $pdf->SetFont('times', '', 14, '', true); 

 //        $pdf->SetPrintHeader(false);  
     
 //        // Add a page
 //        // This method has several options, check the source code documentation for more information.
 //        // The array() inside AddPage method defines the size of the page
 //        $pdf->AddPage('L','A4'); 
     
 //        // set text shadow effect
 //        $pdf->setTextShadow(array('enabled'=>true, 'depth_w'=>0.2, 'depth_h'=>0.2, 'color'=>array(196,196,196), 'opacity'=>1, 'blend_mode'=>'Normal'));
     
 //        // Set some content to print
 //        $html = '
 //        <table style="width:70%;font-size:12px;">
 //            <tr>
 //                <td style="width:25%;">Attendance Report</td>
 //                <td>Thiep</td>
 //            </tr>
 //            <tr>
 //                <td>Vocational Program:</td>
 //                <td>'.$voc_program['voc_program'].'-'.$voc_program['voc_program_acronym'].'</td>
 //            </tr>
 //            <tr>
 //                <td>Report Date Range:</td>
 //                <td>'.date('F d, Y',strtotime($range1)).' - '.date('F d, Y',strtotime($range2)).'</td>
 //            </tr>
 //        </table><br>';

 //        $html1 = '<table border="1" style="width:100%;font-size:12px;">
 //                    <tr>
 //                        <td style="width:9%;">STUDENT NO.</td>
 //                        <td style="width:33%;">STUDENT NAME</td>
 //                        <td style="width:7%;">PRESENT</td>
 //                        <td style="width:8%;">ABSENCES</td>
 //                        <td style="width:5%;">LATES</td>
 //                        <td style="width:6%;">EXCUSE</td>
 //                        <td style="width:8%;">VACATIONS</td>
 //                        <td style="width:6%;">SCORES</td>
 //                        <td style="width:7%;">REMARKS</td>
 //                        <td style="width:11%;">PREF. COURSE</td>
 //                    </tr>';

 //        for ($i=0; $i < count($attendance); $i++) { 
                    
 //        $html1 .=   '<tr>
 //                        <td>'.$attendance[$i]['student_no'].'</td>
 //                        <td>'.$attendance[$i]['arabic_name'].'</td>
 //                        <td>'.$attendance[$i]['presents'].'</td>
 //                        <td>'.$attendance[$i]['absences'].'</td>
 //                        <td>'.$attendance[$i]['lates'].'</td>
 //                        <td>'.$attendance[$i]['excuses'].'</td>
 //                        <td>'.$attendance[$i]['vacations'].'</td>
 //                        <td>'.$attendance[$i]['points'].'</td>
 //                        <td>'.$attendance[$i]['remarks'].'</td>
 //                        <td>'.$attendance[$i]['preferred_course'].'</td>
 //                    </tr>';
 //        }                    

 //        $html1 .= '</table><br><br>

 //        <p style="font-size:12px;">Printed by: '.$this->session->userdata('u_full_name').'</p>

 //        ';
     
 //        // Print text using writeHTMLCell()
 //        $pdf->writeHTMLCell(0, 0, '', '', $html, 0, 1, 0, true, '', true);
 //        $pdf->writeHTMLCell(0, 0, '', '', $html1, 0, 1, 0, true, '', true);
 //        // ---------------------------------------------------------    
     
 //        // Close and output PDF document
 //        // This method has several options, check the source code documentation for more information.

 //        // $pdf->Output('example_001.pdf', 'I');  // FOR PREVIEW PURPOSES  
 //        return $pdf->Output('Thiep-'.$voc_program['voc_program_acronym'].'-Attendance-Report'.date('Y-m-d').'.pdf', 'D');   
 //        // D FOR FORCE DOWNLOAD 
     
 //        //============================================================+
 //        // END OF FILE
 //        //============================================================+
	// }

	// /**
	//  * generateSubjectCodeAttendanceReportPdf function.
	//  * 
	//  * @access public
	//  * @param associative array $attendance
	//  * @param associative array $condition
	//  * @param date $range1
	//  * @param date $range2
	//  * @return pdf file on success.
	//  */
	// public function generateSubjectCodeAttendanceReportPdf($attendance = array(),$condition = array(),$range1,$range2){
	// 	//============================================================+
 //        // File name   : example_001.php
 //        // Begin       : 2008-03-04
 //        // Last Update : 2013-05-14
 //        //
 //        // Description : Example 001 for TCPDF class
 //        //               Default Header and Footer
 //        //
 //        // Author: Nicola Asuni
 //        //
 //        // (c) Copyright:
 //        //               Nicola Asuni
 //        //               Tecnick.com LTD
 //        //               www.tecnick.com
 //        //               info@tecnick.com
 //        //============================================================+
     
 //        /**
 //        * Creates an example PDF TEST document using TCPDF
 //        * @package com.tecnick.tcpdf
 //        * @abstract TCPDF - Example: Default Header and Footer
 //        * @author Nicola Asuni
 //        * @since 2008-03-04
 //        */
     
 //        // create new PDF document
 //        $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);    
     
 //        // set document information
 //        // $pdf->SetCreator(PDF_CREATOR);
 //        // $pdf->SetAuthor('Nicola Asuni');
 //        // $pdf->SetTitle('TCPDF Example 001');
 //        // $pdf->SetSubject('TCPDF Tutorial');
 //        // $pdf->SetKeywords('TCPDF, PDF, example, test, guide');   
     
 //        // set default header data
 //        // $pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE.' 001', PDF_HEADER_STRING, array(0,64,255), array(0,64,128));
 //        // $pdf->setFooterData(array(0,64,0), array(0,64,128)); 
     
 //        // set header and footer fonts
 //        // $pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
 //        // $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));  
     
 //        // set default monospaced font
 //        $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED); 
     
 //        // set margins
 //        // $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
 //        // $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
 //        // $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);    
     
 //        // set auto page breaks
 //        $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM); 
     
 //        // set image scale factor
 //        $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);  
     
 //        // set some language-dependent strings (optional)
 //        if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
 //            require_once(dirname(__FILE__).'/lang/eng.php');
 //            $pdf->setLanguageArray($l);
 //        }   
     
 //        // ---------------------------------------------------------    
     
 //        // set default font subsetting mode
 //        $pdf->setFontSubsetting(true);   
     
 //        // Set font
 //        // dejavusans is a UTF-8 Unicode font, if you only need to
 //        // print standard ASCII chars, you can use core fonts like
 //        // helvetica or times to reduce file size.
 //        $pdf->SetFont('times', '', 14, '', true); 

 //        $pdf->SetPrintHeader(false);  
     
 //        // Add a page
 //        // This method has several options, check the source code documentation for more information.
 //        // The array() inside AddPage method defines the size of the page
 //        $pdf->AddPage('L','A4'); 
     
 //        // set text shadow effect
 //        $pdf->setTextShadow(array('enabled'=>true, 'depth_w'=>0.2, 'depth_h'=>0.2, 'color'=>array(196,196,196), 'opacity'=>1, 'blend_mode'=>'Normal'));
     
 //        // Set some content to print
 //        $html = '
 //        <table style="width:70%;font-size:12px;">
 //            <tr>
 //                <td style="width:25%;">Attendance Report</td>
 //                <td>Thiep</td>
 //            </tr>
 //            <tr>
 //                <td>Subject Code:</td>
 //                <td>'.$condition['subject_code'].'</td>
 //            </tr>
 //            <tr>
 //                <td>Report Date Range:</td>
 //                <td>'.date('F d, Y',strtotime($range1)).' - '.date('F d, Y',strtotime($range2)).'</td>
 //            </tr>
 //        </table><br>';

 //        $html1 = '<table border="1" style="width:100%;font-size:12px;">
 //                    <tr>
 //                        <td style="width:9%;">STUDENT NO.</td>
 //                        <td style="width:33%;">STUDENT NAME</td>
 //                        <td style="width:7%;">PRESENT</td>
 //                        <td style="width:8%;">ABSENCES</td>
 //                        <td style="width:5%;">LATES</td>
 //                        <td style="width:6%;">EXCUSE</td>
 //                        <td style="width:8%;">VACATIONS</td>
 //                        <td style="width:6%;">SCORES</td>
 //                        <td style="width:7%;">REMARKS</td>
 //                        <td style="width:11%;">PREF. COURSE</td>
 //                    </tr>';

 //        for ($i=0; $i < count($attendance); $i++) { 
                    
 //        $html1 .=   '<tr>
 //                        <td>'.$attendance[$i]['student_no'].'</td>
 //                        <td>'.$attendance[$i]['arabic_name'].'</td>
 //                        <td>'.$attendance[$i]['presents'].'</td>
 //                        <td>'.$attendance[$i]['absences'].'</td>
 //                        <td>'.$attendance[$i]['lates'].'</td>
 //                        <td>'.$attendance[$i]['excuses'].'</td>
 //                        <td>'.$attendance[$i]['vacations'].'</td>
 //                        <td>'.$attendance[$i]['points'].'</td>
 //                        <td>'.$attendance[$i]['remarks'].'</td>
 //                        <td>'.$attendance[$i]['preferred_course'].'</td>
 //                    </tr>';
 //        }                    

 //        $html1 .= '</table><br><br>

 //        <p style="font-size:12px;">Printed by: '.$this->session->userdata('u_full_name').'</p>

 //        ';
     
 //        // Print text using writeHTMLCell()
 //        $pdf->writeHTMLCell(0, 0, '', '', $html, 0, 1, 0, true, '', true);
 //        $pdf->writeHTMLCell(0, 0, '', '', $html1, 0, 1, 0, true, '', true);
 //        // ---------------------------------------------------------    
     
 //        // Close and output PDF document
 //        // This method has several options, check the source code documentation for more information.

 //        // $pdf->Output('example_001.pdf', 'I');  // FOR PREVIEW PURPOSES  
 //        return $pdf->Output('Thiep-'.$condition['subject_code'].'-Attendance-Report'.date('Y-m-d').'.pdf', 'D');   
 //        // D FOR FORCE DOWNLOAD 
     
 //        //============================================================+
 //        // END OF FILE
 //        //============================================================+
	// }

	// /**
	//  * generateVocProgramEnlistmentReportCsv function.
	//  * 
	//  * @access public
	//  * @param associative array $voc_program
	//  * @param associative array $students
	//  * @return pdf file on success.
	//  */
	// public function generateVocProgramEnlistmentReportPdf($voc_program = array(),$students = array()){
	// 	//============================================================+
 //        // File name   : example_001.php
 //        // Begin       : 2008-03-04
 //        // Last Update : 2013-05-14
 //        //
 //        // Description : Example 001 for TCPDF class
 //        //               Default Header and Footer
 //        //
 //        // Author: Nicola Asuni
 //        //
 //        // (c) Copyright:
 //        //               Nicola Asuni
 //        //               Tecnick.com LTD
 //        //               www.tecnick.com
 //        //               info@tecnick.com
 //        //============================================================+
     
 //        /**
 //        * Creates an example PDF TEST document using TCPDF
 //        * @package com.tecnick.tcpdf
 //        * @abstract TCPDF - Example: Default Header and Footer
 //        * @author Nicola Asuni
 //        * @since 2008-03-04
 //        */
     
 //        // create new PDF document
 //        $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);    
     
 //        // set document information
 //        // $pdf->SetCreator(PDF_CREATOR);
 //        // $pdf->SetAuthor('Nicola Asuni');
 //        // $pdf->SetTitle('TCPDF Example 001');
 //        // $pdf->SetSubject('TCPDF Tutorial');
 //        // $pdf->SetKeywords('TCPDF, PDF, example, test, guide');   
     
 //        // set default header data
 //        // $pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE.' 001', PDF_HEADER_STRING, array(0,64,255), array(0,64,128));
 //        // $pdf->setFooterData(array(0,64,0), array(0,64,128)); 
     
 //        // set header and footer fonts
 //        // $pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
 //        // $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));  
     
 //        // set default monospaced font
 //        $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED); 
     
 //        // set margins
 //        // $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
 //        // $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
 //        // $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);    
     
 //        // set auto page breaks
 //        $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM); 
     
 //        // set image scale factor
 //        $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);  
     
 //        // set some language-dependent strings (optional)
 //        if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
 //            require_once(dirname(__FILE__).'/lang/eng.php');
 //            $pdf->setLanguageArray($l);
 //        }   
     
 //        // ---------------------------------------------------------    
     
 //        // set default font subsetting mode
 //        $pdf->setFontSubsetting(true);   
     
 //        // Set font
 //        // dejavusans is a UTF-8 Unicode font, if you only need to
 //        // print standard ASCII chars, you can use core fonts like
 //        // helvetica or times to reduce file size.
 //        $pdf->SetFont('times', '', 14, '', true); 

 //        $pdf->SetPrintHeader(false);  
     
 //        // Add a page
 //        // This method has several options, check the source code documentation for more information.
 //        // The array() inside AddPage method defines the size of the page
 //        $pdf->AddPage('L','A4'); 
     
 //        // set text shadow effect
 //        $pdf->setTextShadow(array('enabled'=>true, 'depth_w'=>0.2, 'depth_h'=>0.2, 'color'=>array(196,196,196), 'opacity'=>1, 'blend_mode'=>'Normal'));
     
 //        // Set some content to print
 //        $html = '
 //        <table style="width:70%;font-size:12px;">
 //            <tr>
 //                <td style="width:25%;">Enlistment Report</td>
 //                <td>Thiep</td>
 //            </tr>
 //            <tr>
 //                <td>Vocational Program:</td>
 //                <td>'.$voc_program['voc_program'].'-'.$voc_program['voc_program_acronym'].'</td>
 //            </tr>
 //        </table><br>';

 //        $html1 = '<table border="1" style="width:100%;font-size:12px;">
 //                    <tr>
 //                        <td style="width:10%;">ES</td>
 //                        <td style="width:20%;">STUDENT NO.</td>
 //                        <td style="width:70%;">STUDENT NAME</td>
 //                    </tr>';
 //        $ctr = 1;
 //        for ($i=0; $i < count($students); $i++) { 
 //        $html1 .=   '<tr>
 //                        <td>'.$ctr.'</td>
 //                        <td>'.$students[$i]['student_no'].'</td>
 //                        <td>'.$students[$i]['arabic_name'].'</td>
 //                    </tr>';
 //            $ctr++;
 //        }                    

 //        $html1 .= '</table><br><br>

 //        <p style="font-size:12px;">Printed by: '.$this->session->userdata('u_full_name').'</p>

 //        ';
     
 //        // Print text using writeHTMLCell()
 //        $pdf->writeHTMLCell(0, 0, '', '', $html, 0, 1, 0, true, '', true);
 //        $pdf->writeHTMLCell(0, 0, '', '', $html1, 0, 1, 0, true, '', true);
 //        // ---------------------------------------------------------    
     
 //        // Close and output PDF document
 //        // This method has several options, check the source code documentation for more information.

 //        // $pdf->Output('example_001.pdf', 'I');  // FOR PREVIEW PURPOSES  
 //        return $pdf->Output('Thiep-'.$voc_program['voc_program_acronym'].'-Enlistment-Report'.date('Y-m-d').'.pdf', 'D');   
 //        // D FOR FORCE DOWNLOAD 
     
 //        //============================================================+
 //        // END OF FILE
 //        //============================================================+
	// }

	// /**
	//  * generateSubjectCodeEnlistmnentReportPdf function.
	//  * 
	//  * @access public
	//  * @param associative array $students
	//  * @param associative array $condition
	//  * @return pdf file on success.
	//  */
	// public function generateSubjectCodeEnlistmnentReportPdf($students = array(), $condition = array()){
	// 	//============================================================+
 //        // File name   : example_001.php
 //        // Begin       : 2008-03-04
 //        // Last Update : 2013-05-14
 //        //
 //        // Description : Example 001 for TCPDF class
 //        //               Default Header and Footer
 //        //
 //        // Author: Nicola Asuni
 //        //
 //        // (c) Copyright:
 //        //               Nicola Asuni
 //        //               Tecnick.com LTD
 //        //               www.tecnick.com
 //        //               info@tecnick.com
 //        //============================================================+
     
 //        /**
 //        * Creates an example PDF TEST document using TCPDF
 //        * @package com.tecnick.tcpdf
 //        * @abstract TCPDF - Example: Default Header and Footer
 //        * @author Nicola Asuni
 //        * @since 2008-03-04
 //        */
     
 //        // create new PDF document
 //        $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);    
     
 //        // set document information
 //        // $pdf->SetCreator(PDF_CREATOR);
 //        // $pdf->SetAuthor('Nicola Asuni');
 //        // $pdf->SetTitle('TCPDF Example 001');
 //        // $pdf->SetSubject('TCPDF Tutorial');
 //        // $pdf->SetKeywords('TCPDF, PDF, example, test, guide');   
     
 //        // set default header data
 //        // $pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE.' 001', PDF_HEADER_STRING, array(0,64,255), array(0,64,128));
 //        // $pdf->setFooterData(array(0,64,0), array(0,64,128)); 
     
 //        // set header and footer fonts
 //        // $pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
 //        // $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));  
     
 //        // set default monospaced font
 //        $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED); 
     
 //        // set margins
 //        // $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
 //        // $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
 //        // $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);    
     
 //        // set auto page breaks
 //        $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM); 
     
 //        // set image scale factor
 //        $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);  
     
 //        // set some language-dependent strings (optional)
 //        if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
 //            require_once(dirname(__FILE__).'/lang/eng.php');
 //            $pdf->setLanguageArray($l);
 //        }   
     
 //        // ---------------------------------------------------------    
     
 //        // set default font subsetting mode
 //        $pdf->setFontSubsetting(true);   
     
 //        // Set font
 //        // dejavusans is a UTF-8 Unicode font, if you only need to
 //        // print standard ASCII chars, you can use core fonts like
 //        // helvetica or times to reduce file size.
 //        $pdf->SetFont('times', '', 14, '', true); 

 //        $pdf->SetPrintHeader(false);  
     
 //        // Add a page
 //        // This method has several options, check the source code documentation for more information.
 //        // The array() inside AddPage method defines the size of the page
 //        $pdf->AddPage('L','A4'); 
     
 //        // set text shadow effect
 //        $pdf->setTextShadow(array('enabled'=>true, 'depth_w'=>0.2, 'depth_h'=>0.2, 'color'=>array(196,196,196), 'opacity'=>1, 'blend_mode'=>'Normal'));
     
 //        // Set some content to print
 //        $html = '
 //        <table style="width:70%;font-size:12px;">
 //            <tr>
 //                <td style="width:25%;">Enlistment Report</td>
 //                <td>Thiep</td>
 //            </tr>
 //            <tr>
 //                <td>Subject Code:</td>
 //                <td>'.$condition['subject_code'].'</td>
 //            </tr>
 //        </table><br>';

 //        $html1 = '<table border="1" style="width:100%;font-size:12px;">
 //                    <tr>
 //                        <td style="width:10%;">ES</td>
 //                        <td style="width:20%;">STUDENT NO.</td>
 //                        <td style="width:70%;">STUDENT NAME</td>
 //                    </tr>';

 //        for ($i=0; $i < count($students); $i++) { 
 //        $ctr = 1;
 //        $html1 .=   '<tr>
 //                        <td>'.$ctr.'</td>
 //                        <td>'.$students[$i]['student_no'].'</td>
 //                        <td>'.$students[$i]['arabic_name'].'</td>
 //                    </tr>';
 //            $ctr++;
 //        }                    

 //        $html1 .= '</table><br><br>

 //        <p style="font-size:12px;">Printed by: '.$this->session->userdata('u_full_name').'</p>

 //        ';
     
 //        // Print text using writeHTMLCell()
 //        $pdf->writeHTMLCell(0, 0, '', '', $html, 0, 1, 0, true, '', true);
 //        $pdf->writeHTMLCell(0, 0, '', '', $html1, 0, 1, 0, true, '', true);
 //        // ---------------------------------------------------------    
     
 //        // Close and output PDF document
 //        // This method has several options, check the source code documentation for more information.

 //        // $pdf->Output('example_001.pdf', 'I');  // FOR PREVIEW PURPOSES  
 //        return $pdf->Output('Thiep-'.$condition['subject_code'].'-Enlistment-Report'.date('Y-m-d').'.pdf', 'D');   
 //        // D FOR FORCE DOWNLOAD 
     
 //        //============================================================+
 //        // END OF FILE
 //        //============================================================+
	// }

}