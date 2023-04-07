<?php
class Upload {
     private $files = [];
     private $image_formats = ['jpg', 'jpeg', 'png'];
     private $dir = "static";
     private $public_path = __DIR__;
     private $type = '';
     private $size = '';
     private $file_name = '';
     private $error = [];
     public function __construct($files)
     {
         $this->files = $files;
     }

    public function upload(){
        if(!empty($this->files)){
          foreach($this->files as $file){
              $arrayFiles = explode('.', $file['name']);
              $extension = strtolower(end($arrayFiles));
              if (!in_array(strtolower($extension), $this->image_formats)) {
                  $this->error['errors'] = 'Định dạng phải nằm trong các format sau đây: jpeg, jpg, png';
              } else{
                  $fileName = $arrayFiles[0];
                  $picture = sha1($fileName . time()) . '.' . $extension;
                  $path  = $this->createDynamicFolder() ;
                  $destination = $path . '/' . $picture;
                  if (move_uploaded_file($file['tmp_name'], $destination)) {
                      echo "Upload success";
                  } else{
                      echo "Upload fail";
                  }
              }

          }
        }
     }
     public function createDynamicFolder(): string
     {
         $path = $this->public_path . '/static/' . date('Y/m/d');
         if (! is_dir ( $path )) {
             mkdir ( $path, 0777, true );
         }
         return $path;
     }
    /**
     * @return string
     */
    public function getDir(): string
    {
        return $this->dir;
    }

    /**
     * @return array
     */
    public function getError(): array
    {
        return $this->error;
    }

    /**
     * @return string
     */
    public function getFileName(): string
    {
        return $this->file_name;
    }

    /**
     * @return array
     */
    public function getFiles(): array
    {
        return $this->files;
    }

    /**
     * @return string[]
     */
    public function getImageFormats(): array
    {
        return $this->image_formats;
    }

    /**
     * @return string
     */
    public function getPublicPath(): string
    {
        return $this->public_path;
    }

    /**
     * @return string
     */
    public function getSize(): string
    {
        return $this->size;
    }

    /**
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * @param string $type
     */
    public function setType(string $type)
    {
        $this->type = $type;
    }

    /**
     * @param string $file_name
     */
    public function setFileName(string $file_name)
    {
        $this->file_name = $file_name;
    }

    /**
     * @param string $size
     */
    public function setSize(string $size)
    {
        $this->size = $size;
    }
}