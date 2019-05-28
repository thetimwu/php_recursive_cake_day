<?php namespace Console;
use Symfony\Component\Console\Command\Command as SymfonyCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
/**
 * Author: Chidume Nnamdi <kurtwanger40@gmail.com>
 */
class Command extends SymfonyCommand
{
    
    public function __construct()
    {
        parent::__construct();
    }
    protected function generateCakeDay(InputInterface $input, OutputInterface $output)
    {
        // outputs multiple lines to the console (adding "\n" at the end of each line)
        $output -> writeln([
            '====**** Employee Cake Day App ****====',
            '==========================================',
            '',
        ]);
        
        // outputs a message without adding a "\n" at the end of the line
        //$output -> write($this -> getCakeDate() .', '. $input -> getArgument('username'));
        $array = explode("\n", file_get_contents('DOB.txt'));
        $array = $this->convertArray($array);
        $wkd = $this->getNextWorkingDay($array[0][1],0);
        $output->writeln(var_dump($wkd));
    }
    private function getCakeDate($array_date)
    {
        /* This sets the $time variable to the current hour in the 24 hour clock format */
        $time = date("H");
        /* Set the $timezone variable to become the current timezone */
        $timezone = date("e");
        /* If the time is less than 1200 hours, show good morning */
        if ($time < "12") {
            return "Good morning";
        }        
    }

    private function convertArray($array) {
        $newArray = array();
        foreach($array as $dob) {
            array_push($newArray, preg_split("/[\s,]+/", $dob)) ;
        }

        $formattedArray = array();
        foreach($newArray as $nArray) {
            array_push($nArray, "first working day", "cake day", "cake size");
            array_push($formattedArray, $nArray);
        }
        return $formattedArray;
    }

    private function getNextWorkingDay($dob, $flag) {
        $workingDays = [1,2,3,4,5];
        $holidayDays = ['*-12-25', '*-12-26', '*-01-01'];
        //$dob = '2019-05-25';
        if ($this->isHoliday($dob)) {
            // if birthday is holiday or weekend, then add 1 day a time to get the first working day
            $firstWorkingDay = date('Y-m-d',strtotime('+1 day', strtotime($dob)));
            //print_r($firstWorkingDay);
            //$dob = $firstWorkingDay;
            $flag = 1;
            $this->getNextWorkingDay($firstWorkingDay, 1);
        } else {
            if ($flag===1) {
                if ($this->isHoliday($dob)) {
                    //print_r($dob);
                    $this->getNextWorkingDay($dob, 1);
                } else {
                    print_r($dob);
                    // return cake day
                    return $dob;
                }
            } else {
                // if birthday is working day, add 1 day to get the first working day
                $fwk = strtotime($dob);
                $firstWorkingDay = date('Y-m-d',strtotime('+1 day', $fwk));

                if ($this->isHoliday($firstWorkingDay)) {
                    //print_r($firstWorkingDay);
                    $dob = $firstWorkingDay;
                    $this->getNextWorkingDay($firstWorkingDay, 1);
                } else {
                    // return cake day
                    $flag = 0;
                    return $firstWorkingDay;
                }
            } 
            
            //$day_int = date('N', strtotime($firstWorkingDay));
            //$firstWorkingDay = '2019-05-25';
            //print_r($this->isHoliday($firstWorkingDay));
            
        }    
    }

    private function isHoliday($date) {
        $weekendDays = [6,7];
        $holidayDays = ['*-12-25', '*-12-26', '*-01-01'];
        $day_int = date('N', strtotime($date));

        $newDate = date('*-m-d', strtotime($date));
        if (in_array($day_int, $weekendDays) || in_array($newDate, $holidayDays) || in_array($date, $holidayDays)) {
            return true;
        } else {
            return false;
        }
    } 
}