tuiValidatorImage
=================

What it is
----------

This is an extension of the standard sfValidatorFile validator that checks an uploaded image fits within a min/max width and height. It's written for symfony 1.4

How to use it
-------------

* Copy the file into your project's lib folder (or use an svn:externals property)
* Available Options
	* path - where to save the uploaded file (required)
	* mime_types - acceptable files, 'web_images' covers all 3 types (required)
	* required - whether to accept no file as valid or not
	* min_width - Minimum allowed width for the image
	* max_width - Maximum allowed width for the image
	* min_height - Minimum allowed width for the image
	* max_height - Maximum allowed width for the image
	* ratio
		* array(w,h) - specifies the width to height ratio
		* 'square' - specifies the image must be square
* In your form class, override the validator for the image widget. Here's an example for using max and min sizes, including the upload/edit/delete widget:

```php
if ($this->getObject()->menu_image) {
  $this->setWidget('menu_image', new sfWidgetFormInputFileEditable(array(
    'file_src'      => '/'.basename(sfConfig::get('sf_upload_dir')).'/'.$this->getObject()->menu_image,
    'edit_mode'     => !$this->isNew(),
    'is_image'      => true,
    'with_delete'   => true,
    'delete_label'  => 'Remove this image',
  )));
  $this->setValidator('menu_image_delete', new sfValidatorBoolean());
} else {
  $this->setWidget('menu_image', new sfWidgetFormInputFile());
}

$this->setValidator('menu_image', new tuiValidatorImage(
  array(
    'mime_types' => 'web_images',
    'path'       => sfConfig::get('sf_upload_dir'),
    'required'   => false,
    'min_width'  => 100,
    'min_height' => 75,
    'max_width'  => 100,
    'max_height' => 75,
  ), 
  array('mime_types' => 'Unsupported image type. Please use JPEG, GIF, or PNG only.')
));
```

Licence
-------

Copyright (c) 2010 Tui Interactive Media

Permission is hereby granted, free of charge, to any person obtaining a copy
of this software and associated documentation files (the "Software"), to deal
in the Software without restriction, including without limitation the rights
to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
copies of the Software, and to permit persons to whom the Software is
furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in all
copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
SOFTWARE.