<?php
class TextValidator
{
  public function validatePost($title, $category, $date, $body)
  {
    $errors = [];

    // Validate title
    if ($this->strIsEmpty($title)) {
      $errors['title'] = "Fyll i en titel!";
    } elseif ($this->exceedsMaxLength($title, 254)) {
      $errors['title'] = 'Titeln är för lång korta ner den!';
    }

    // Validate category
    if ($this->strIsEmpty($category)) {
      $errors['category'] = 'Välj en kategori!';
    }

    // Validate date

    if ($this->strIsEmpty($date)) {
      $errors['date'] = 'Välj minst ett datum!';
    }

    // Validate body
    if ($this->strIsEmpty($body)) {
      $errors['body'] = 'Fyll i en beskrivning!';
    } elseif ($this->exceedsMaxLength($body, 65500)) {
      $errors['body'] = 'Beskrivningen är för lång korta ner den!';
    }

    return $errors;
  }

  /**
   * Checks if a string is empty not including whitespace.
   * 
   * @param string $string The text string that is checked
   * @return bool Returns true if string is empty, false if it contains characters. 
   */
  public function strIsEmpty($string)
  {
    if (strlen(trim($string)) <= 0) {
      return true;
    } else {
      return false;
    }
  }

  /**
   * Checks if a string is empty not including whitespace.
   * 
   * @param string $string The text string that is checked.
   * @param int $max The max length of the string.
   * @return bool Returns false if string is too long, true if it's under the max length. 
   */
  public function exceedsMaxLength($string, $max)
  {
    if (strlen(trim($string)) > $max) {
      return true;
    } else {
      return false;
    }
  }
}
