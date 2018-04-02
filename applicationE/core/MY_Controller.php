<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class MY_Controller extends CI_Controller {

    function __construct() {
        parent::__construct();

        $this->load->library('session');
        $this->load->model('role');
        $this->data["user_id"] = $this->session->userdata("user_id");
        $this->data['logged_in'] = $this->data['user_id'] != FALSE ? TRUE : FALSE;
        if ($this->data['logged_in']) {
            $this->data['permissions'] = $this->role->getPermissions($this->data["user_id"]);
            $this->data["admin_permission"] = $this->checkAdminPermissions();
        }
        $this->load->helper('html');
    }

    protected function comprobarRol($rol) {
        $role_id = $this->role->getRoleId($rol);
        $admin_role = $this->role->getRoleId("admin");
        foreach ($this->data["permissions"] as $permission) {
            if ($permission == $role_id || $permission == $admin_role) {
                return TRUE;
            }
        }
        redirect("paginas/checkRoleRedirect");
    }

    protected function checkRol($rol) {
        $role_id = $this->role->getRoleId($rol);
        foreach ($this->data["permissions"] as $permission) {
            if ($permission == $role_id) {
                return TRUE;
            }
        }
        return FALSE;
    }

    protected function checkAdminPermissions() {
        $role_id = $this->role->defaultRole();
        foreach ($this->data["permissions"] as $permission) {
            if ($permission != $role_id) {
                return TRUE;
            }
        }
        return FALSE;
    }

    protected function renderMenu() {
        $data['usuarios'] = $this->checkRol('admin');
        $data['cliente'] = $this->checkRol('admin');
        $data['programa'] = $this->checkRol('organizador') || $this->checkRol('admin');
        $data['persona'] = $this->checkRol('reclutamiento') || $this->checkRol('admin') || $this->checkRol('jefe_reclutamiento');
        $data['informe'] = $this->checkRol('informe') || $this->checkRol('admin');

        return $data;
    }

    function createDateRangeArray($strDateFrom, $strDateTo) {

        $aryRange = array();

        $iDateFrom = mktime(1, 0, 0, substr($strDateFrom, 5, 2), substr($strDateFrom, 8, 2), substr($strDateFrom, 0, 4));
        $iDateTo = mktime(1, 0, 0, substr($strDateTo, 5, 2), substr($strDateTo, 8, 2), substr($strDateTo, 0, 4));

        if ($iDateTo >= $iDateFrom) {
            array_push($aryRange, date('Y-m-d', $iDateFrom)); // first entry
            while ($iDateFrom < $iDateTo) {
                $iDateFrom+=86400; // add 24 hours
                array_push($aryRange, date('Y-m-d', $iDateFrom));
            }
        }
        return $aryRange;
    }

    function convert_number_to_words($number) {

        $hyphen = '-';
        $conjunction = ' ';
        $separator = ', ';
        $negative = 'menos ';
        $decimal = ' con ';
        $dictionary = array(
            0 => 'cero',
            1 => 'uno',
            2 => 'dos',
            3 => 'tres',
            4 => 'cuatro',
            5 => 'cinco',
            6 => 'seis',
            7 => 'siete',
            8 => 'ocho',
            9 => 'nueve',
            10 => 'diez',
            11 => 'once',
            12 => 'doce',
            13 => 'trece',
            14 => 'catorce',
            15 => 'quince',
            16 => 'dieciseis',
            17 => 'diecisiete',
            18 => 'diciocho',
            19 => 'diecinueve',
            20 => 'veinte',
            30 => 'treinta',
            40 => 'cuarenta',
            50 => 'cincuenta',
            60 => 'sesenta',
            70 => 'setenta',
            80 => 'ochenta',
            90 => 'noventa',
            100 => 'cientos',
            1000 => 'mil',
            1000000 => 'millones',
            1000000000 => 'mil',
            1000000000000 => 'billones',
            1000000000000000 => 'mil',
            1000000000000000000 => 'trillones'
        );

        if (!is_numeric($number)) {
            return false;
        }

        if (($number >= 0 && (int) $number < 0) || (int) $number < 0 - PHP_INT_MAX) {
            // overflow
            trigger_error(
                    'convert_number_to_words only accepts numbers between -' . PHP_INT_MAX . ' and ' . PHP_INT_MAX, E_USER_WARNING
            );
            return false;
        }

        if ($number < 0) {
            return $negative . $this->convert_number_to_words(abs($number));
        }

        $string = $fraction = null;

        if (strpos($number, '.') !== false) {
            list($number, $fraction) = explode('.', $number);
        }

        switch (true) {
            case $number < 21:
                $string = $dictionary[$number];
                break;
            case $number < 100:
                $tens = ((int) ($number / 10)) * 10;
                $units = $number % 10;
                $string = $dictionary[$tens];
                if ($units) {
                    $string .= $hyphen . $dictionary[$units];
                }
                break;
            case $number < 1000:
                $hundreds = $number / 100;
                $remainder = $number % 100;
                $string = $dictionary[$hundreds] . ' ' . $dictionary[100];
                if ($remainder) {
                    $string .= $conjunction . $this->convert_number_to_words($remainder);
                }
                break;
            default:
                $baseUnit = pow(1000, floor(log($number, 1000)));
                $numBaseUnits = (int) ($number / $baseUnit);
                $remainder = $number % $baseUnit;
                $string = $this->convert_number_to_words($numBaseUnits) . ' ' . $dictionary[$baseUnit];
                if ($remainder) {
                    $string .= $remainder < 100 ? $conjunction : $separator;
                    $string .= $this->convert_number_to_words($remainder);
                }
                break;
        }

        $string .= " dólares";

        if (null !== $fraction && is_numeric($fraction)) {
            $string .= $decimal;
            $string .= $this->convert_number_to_words($fraction);
            $string .= " centavos";
        }

        return $string;
    }

}
