<?php

namespace App\Http\Controllers;

use App\Seat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Http\Requests;

class ReservationController extends Controller
{
    public function index(){

        return view('Reservation');
    }

    /**
     * @return string
     * Function Used for reset the reservation
     */
    public function reset(){
        Seat::delete();
        return 'success';
    }

    /**
     * @param Request $request
     * @return string
     * Function calculate and booked the seats
     */
    public function calculation(Request $request)
    {
        $seat = [];
        for ($i = 11; $i >= 0; $i--) {
            for ($j = 0; $j < 7; $j++) {
                $seat[$i][$j] = 0;
            }
        }

        $seatBooked = $request['seatsNo'];
        $seats = Seat::select('seats')->get();

        $seatsBookingLimit = count($seats);

        if($seatsBookingLimit)
        {
            for ($i=0; $i< $seatsBookingLimit;$i++){
                $calculations = $seats[$i]['seats'];

                $rowIndex = $calculations/7;
		        floor($rowIndex);
                $colIndex = $calculations%7;
                $seat[$rowIndex -1][$colIndex] = 1;
            }
        }

        if($seatBooked)
            $bookedSeat = $this->SeatBooking($seat, $seatBooked);

        else{
            return $this->printArray($seat);
        }

            if($bookedSeat){
                $seat = $bookedSeat;
                return $this->printArray($bookedSeat);
            }
            else
            {
                $bookedSeat = $this->SeatBookingNotInSameRow($seat, $seatBooked);
                if($bookedSeat)
                    return $this->printArray($bookedSeat);
                else
                    return "NO SPACE IS AVAILABLE";
            }
    }

    /**
     * @param $bookingSeat
     * @param $seatBook
     * @return mixed
     *
     * Function used for booked the seats in the same Row
     */
    public function SeatBooking($bookingSeat, $seatBook)
    {
        $seatBooked = 0;
        if ($seatBook <= 7 && $seatBook > 0) {
            for ($i = 11; $i >= 0; $i--) {

                $counter = 0;
                $rowLimit = ($i == 11) ? 3 : 7;

                if(!$seatBooked) {

                    for ($j = 0; $j < $rowLimit; $j++) {

                        if ($bookingSeat[$i][$j] == 0)
                            $counter++;

                        if ($counter == $seatBook) {
                            $loopstart = $j - $counter + 1;
                            $loopLimit = $loopstart + $counter;

                            while ($loopstart < $loopLimit) {
                                $bookingSeat[$i][$loopstart] = 1;
                                $loopstart++;
                            }
                            $seatBooked = 1;
                        }
                    }
                }
            }
        }
        //Validation form Backend
        else{
            echo'Please type authorise number';
        }

        if($seatBooked)
            return $bookingSeat;
        else
            return 0;
    }

    /**
     * @param $seat
     * @param $seatBooking
     * @return int|mixed
     * Function used for calculating and Booked the seats in nearby row
     */
    public function SeatBookingNotInSameRow($seat, $seatBooking)
    {
        $counter = 0;
        for ($i = 11; $i >= 0; $i--) {
            $rowLimit = ($i == 11) ? 3 : 7;
            for ($j = 0; $j < $rowLimit; $j++) {
                    if ($seat[$i][$j] == 0) {
                        $counter++;
                    }
            }
        }
        if($counter >= $seatBooking){
            $seat = $this->booking($seat, $seatBooking);
            return $seat;
        }
        else{
            return 0;
        }

    }

    /**
     * @param $seat
     * @param $seatBooking
     * @return mixed
     * Function Used for booked the seats in nearby row
     */
    public function booking($seat , $seatBooking)
    {
        $counter = 0;
        $booked = 0;
        for ($i = 11; $i >= 0; $i--) {
            $rowLimit = ($i == 11) ? 3 : 7;
                for ($j = 0; $j < $rowLimit; $j++) {
		   if (!$booked) {
               if ($seat[$i][$j] == 0) {
                   $seat[$i][$j] = 1;
                   $counter++;
               }
           }
                    if(!$booked){
                        if ($seat[$i][$j] == 0) {
                            $seat[$i][$j] = 1;
                            $counter++;
                        }
                    }
		   }

                    if ($counter == $seatBooking)
                        $booked = 1;
        }
        return $seat;
    }

    /**
     * @param $bookingSeat
     * Print the Booked seat
     */
    public function printArray($bookingSeat)
    {
        for($rowIndex =0 ; $rowIndex < 11; $rowIndex ++){
            for($colIndex = 0; $colIndex < 7; $colIndex++){
                if($bookingSeat[$rowIndex][$colIndex] == 1){
                    $seatNo = $rowIndex*7 + $colIndex;
                    $seatsObj = Seat::where('seats', $seatNo)->get();
                    if(count($seatsObj) == 0)
                        Seat::insert('seat', $seatNo);
                }
            }
        }
        return ($bookingSeat);
    }

}
