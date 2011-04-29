 <?php 
 // return the month for a given date or the current date if no date given
 
 
 function getmonth ($month = null, $year = null)
  {
      // The current month is used if none is supplied.
      if (is_null($month))
          $month = date('n');

      // The current year is used if none is supplied.
      if (is_null($year))
          $year = date('Y');

      // Verifying if the month exist
      if (!checkdate($month, 1, $year))
          return null;

      // Calculating the days of the month
      $first_of_month = mktime(0, 0, 0, $month, 1, $year);
      $days_in_month = date('t', $first_of_month);
      $last_of_month = mktime(0, 0, 0, $month, $days_in_month, $year);

      $m = array();
      $m['first_mday'] = 1;
      $m['first_wday'] = date('w', $first_of_month);
      $m['first_weekday'] = strftime('%A', $first_of_month);
      $m['first_yday'] = date('z', $first_of_month);
      $m['first_week'] = date('W', $first_of_month);
      $m['last_mday'] = $days_in_month;
      $m['last_wday'] = date('w', $last_of_month);
      $m['last_weekday'] = strftime('%A', $last_of_month);
      $m['last_yday'] = date('z', $last_of_month);
      $m['last_week'] = date('W', $last_of_month);
      $m['mon'] = $month;
      $m['month'] = strftime('%B', $first_of_month);
      $m['year'] = $year;

      return $m;
  }
  
  ?>