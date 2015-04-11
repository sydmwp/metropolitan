<?php
//Queries
$pioneer_select = "SELECT first_name, last_name, gender, phone FROM pioneers WHERE id = ?";
$pioneer_phone_select = "SELECT id, first_name, last_name, gender FROM pioneers WHERE phone = ?";
$couple_select = "SELECT id FROM couples WHERE brother_id = ? AND sister_id = ?";
$location_select = "SELECT name FROM locations WHERE id = ?";
$shift_select = "SELECT id FROM shifts WHERE date = ? AND time = ? AND location_id = ?";
$shift_date_select = "SELECT overseer_id, pioneer_id, pioneer_b_id FROM shifts WHERE date = ?";
$shift_user_select = "SELECT date FROM shifts WHERE (overseer_id = ? OR pioneer_id = ? OR pioneer_b_id = ?) ORDER BY date DESC";
$shift_record_select = "SELECT id, overseer_id, pioneer_id, pioneer_b_id FROM shifts WHERE date = ? AND location_id = ? AND time = ?";
$shift_unrecorded_select = "SELECT id, confirmed, recorded FROM shifts WHERE date = ? AND time = ? AND location_id = ? AND recorded != 'y'";
$shift_unconfirmed_select = "SELECT id, date, time, location_id FROM shifts WHERE confirmed = ?";
$day_check = "SELECT confirmed, full FROM shifts WHERE date = ? AND location_id != '50'";
$shift_test = "SELECT id, confirmed FROM shifts WHERE date = ? AND (overseer_id = ? OR pioneer_id = ? OR pioneer_b_id = ?)";
$shift_detail = "SELECT id, location_id, time, overseer_id, pioneer_id, pioneer_b_id FROM shifts WHERE (overseer_id = ? OR pioneer_id = ? OR pioneer_b_id = ?) AND date = ?";
$shift_insert = "INSERT INTO shifts " .
  "(location_id, date, time, overseer_id, pioneer_id, pioneer_b_id, confirmed, full) VALUES " .
  "(?          , ?   , ?   , ?          , ?         , ?           , ?        , ?   )";
$placements_record = "UPDATE shifts SET books = ?, magazines = ?, brochures = ?, comments = ?, recorded = 'y'  WHERE id = ?";
$shift_update = "UPDATE shifts SET overseer_id = ?, pioneer_id = ?, pioneer_b_id = ?, full = ?, confirmed = ? WHERE id = ?";
$empty_check = "SELECT overseer_id, pioneer_id, pioneer_b_id FROM shifts WHERE id = ?";
$shift_delete = "DELETE FROM shifts WHERE id = ?";
$overseer_update = "UPDATE shifts SET overseer_id = '' WHERE id = ?";
$pioneer_update = "UPDATE shifts SET pioneer_id = '' WHERE id = ?";
$pioneer_b_update = "UPDATE shifts SET pioneer_b_id = '' WHERE id = ?";
//
?>