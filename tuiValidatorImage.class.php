<?php

class tuiValidatorImage extends sfValidatorFile
{
  protected function doClean($value)
  {
    if (!is_array($value) || !isset($value['tmp_name']))
    {
      throw new sfValidatorError($this, 'invalid', array('value' => (string) $value));
    }
    // Check file is an image and get size info
    $old_error_code = error_reporting(0);
    $info = getimagesize($value['tmp_name']);
    error_reporting($old_error_code);
    
    if ($info === false)
    {
      throw new sfValidatorError($this, 'not_image', array('value' => (string) $value));
    }
    if ($this->getOption('ratio'))
    {
       $ratio = $this->getOption('ratio');
       // if square option set check is square
       if($ratio == 'square' && $info[0] != $info[1])
       {
          throw new sfValidatorError($this, 'not_square', array('value' => (string) $value));
       }
       // if ratio set then check it is correct
       elseif(is_array($ratio) && $info[0] / $info[1] != $ratio[0] / $ratio[1])
       {
          throw new sfValidatorError($this, 'not_ratio', array('value' => (string) $value));
       }
    }
     // Compare against min/max values if given
    if ($this->getOption('max_width') && $info[0] > $this->getOption('max_width'))
    {
      throw new sfValidatorError($this, 'max_height', array('value' => (string) $value));
    }
    
    if ($this->getOption('max_height') && $info[1] > $this->getOption('max_height'))
    {
      throw new sfValidatorError($this, 'max_height', array('value' => (string) $value));
    }
    
    if ($this->getOption('min_width') && $info[0] < $this->getOption('min_width'))
    {
      throw new sfValidatorError($this, 'min_height', array('value' => (string) $value));
    }
    
    if ($this->getOption('min_height') && $info[1] < $this->getOption('min_height'))
    {
      throw new sfValidatorError($this, 'min_height', array('value' => (string) $value));
    }
    return parent::doClean($value);
  }
 
  protected function configure ($options = array(), $messages = array())
  {
    $this->addOption('max_width');
    $this->addOption('max_height');
    $this->addOption('min_width');
    $this->addOption('min_height');
    $this->addOption('ratio');
    $this->addMessage('max_width', 'Uploaded image is too wide.');
    $this->addMessage('max_height', 'Uploaded image is too tall.');
    $this->addMessage('min_width', 'Uploaded image is not wide enough.');
    $this->addMessage('min_height', 'Uploaded image is not tall enough.');
    $this->addMessage('not_image', 'Uploaded file is not an image.');
    $this->addMessage('not_square', 'The image must be square.');
    if(isset($options['ratio']) && is_array($options['ratio'])){
       $this->addMessage('not_ratio', 'The image must be the correct dimensions ('.$options['ratio'][0].' x '.$options['ratio'][1].')');
    }
    parent::configure($options, $messages);
  }
}
