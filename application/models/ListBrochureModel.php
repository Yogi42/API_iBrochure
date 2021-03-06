<?php

class ListbrochureModel extends CI_Model {    

    public function GetAll() {
        $query =  $this->db->query("SELECT lb.*, c.Name as Category, u.Name as Username, u.Picture as Avatar FROM list_brochure lb
                                    LEFT JOIN user_account u on u.id = lb.UseraccountId
                                    LEFT JOIN category c on c.Id = lb.CategoryId
                                    ORDER BY PostingDate DESC");
        return $query->result();
    }

    public function GetById($id) {
        $id    = $this->db->escape_str($id);
        $query =  $this->db->query("SELECT lb.*, c.Name as Category, u.Name as Username, u.Picture as Avatar 
                                    FROM list_brochure lb
                                    LEFT JOIN user_account u on u.id = lb.UseraccountId
                                    LEFT JOIN category c on c.Id = lb.CategoryId
                                    WHERE lb.Id = $id 
                                    ORDER BY PostingDate DESC");
        return $query->result();
    }

    public function Save($id, $param) {
        if ($id == 0) {
            unset($param['ListPicture']);
            $query = $this->db->insert("list_brochure", $param);
        } else {
            $id           = $this->db->escape_str($id);
            $title        = $this->db->escape_str($param['Title']);
            $telephone    = $this->db->escape_str($param['Telephone']);
            $address      = $this->db->escape_str($param['Address']);
            $description  = $this->db->escape_str($param['Description']);
            $categoryId   = $this->db->escape_str($param['CategoryId']);
            $pictureFront = $this->db->escape_str($param['PictureFront']);
            $pictureBack  = $this->db->escape_str($param['PictureBack']);

            $this->db->query("UPDATE list_brochure 
                SET Title = '$title',
                    Telephone = '$telephone',
                    Address = '$address',
                    Description = '$description',
                    CategoryId = '$categoryId',
                    PictureFront = '$pictureFront',
                    PictureBack = '$pictureBack'
                WHERE Id = $id");
        }
    }
    
    public function Delete($id) {
        $id = $this->db->escape_str($id);
            
        $this->db->query("DELETE FROM list_brochure WHERE Id = $id");
    }

    public function getListBrochureByPage($param) {
        $page   = $this->db->escape_str($param['Page']);;
        $size   = $this->db->escape_str($param['Size']);;
        $page   = ($page - 1) * $size;
        
        $query = $this->db->query('SELECT lb.*, u.Id as UseraccountId, u.Name as Username, u.Picture as Avatar, c.Name as Category 
                                   FROM list_brochure lb
                                   LEFT JOIN user_account u ON u.id = lb.UseraccountId
                                   LEFT JOIN category c ON c.Id = lb.CategoryId 
                                   ORDER BY PostingDate DESC
                                   LIMIT '.$page.', '.$size);
        return $query->result();
    }

    public function getAllByUseraccountByPage($param) {
        $id   = $this->db->escape_str($param['Id']);;
        $page = $this->db->escape_str($param['Page']);;
        $size = $this->db->escape_str($param['Size']);;
        $page = ($page - 1) * $size;
        
        $query = $this->db->query('SELECT lb.*, u.Id as UseraccountId, u.Name as Username, u.Picture as Avatar, c.Name as Category 
                                   FROM list_brochure lb
                                   LEFT JOIN user_account u on u.Id = lb.UseraccountId
                                   LEFT JOIN category c ON c.Id = lb.CategoryId 
                                   WHERE u.Id = '.$id.
                                   ' ORDER BY PostingDate DESC'.
                                   ' LIMIT '.$page.', '.$size);
        return $query->result();
    }
}