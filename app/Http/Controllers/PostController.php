<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class PostController extends Controller
{
    public function upload(Request $request){
        $validator = Validator::make($request->all(), [
            'file' => 'image|mimes:jpeg,png,jpg|max:10000',
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors(),404);
        } else {
            $pic = $_FILES["file"]["name"];
            $target_dir = FILE_ROOT.'/user_upload';
            $target_file = $target_dir . basename($_FILES["file"]["name"]);
            $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
            $uploadOk = 1;

            //check if the file is an actual image.
            $check = getimagesize($_FILES["file"]["tmp_name"]);
            if ($check !== false) {
                $uploadOk = 1;
            } else {
                $uploadOk = 0;
                return response("File is not an image.");
            }
            //check if the file exists.
            if (file_exists($target_file)) {
                $uploadOk = 0;
                return response("Sorry, file already exists. Try renaming your filename");
            }

            // Check file size
            if ($_FILES["file"]["size"] < 5000) {
                $uploadOk = 0;
                return response("Sorry, your file is too large.");
            }

            // Allow certain file formats
            if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
                && $imageFileType != "gif") {
                $uploadOk = 0;
                return response("Sorry, only JPG, JPEG, PNG & GIF files are allowed.");
            }
            if ($uploadOk == 0) {
                return response("Sorry, your file was not uploaded.");
            } else {
                if(move_uploaded_file($_FILES["file"]["tmp_name"], $target_file)) {
                    $query1 = DB::table('posts')->insertGetId(['id'=>'','user_id'=>$user_id,'caption'=>$caption,'pic'=>$pic,'like_count'=>'','comment_count'=>'','date_time'=>$date_time]);
                    if($query1) {
                        $sql2 = DB::select("SELECT post.*, auth.id as user_id, auth.name, auth.username, auth.addr FROM auth Inner Join post on post.user_id=auth.id Where id=?",[]);

                    }
                               $result = $conn->query($sql2);
                        if ($result->num_rows > 0) {
                            echo $result->fetch_assoc();
                        }
                    }
                } else {
                    return response("Sorry, there was an error uploading your file.");
                }
            }
        }
    }
    public function load_posts(){
//        DB::select('SELECT post.*, auth.id as user_id, auth.name, auth.username, auth.addr FROM auth Inner Join post on post.user_id=auth.id ORDER BY post.id DESC LIMIT 3',[]);
//        if (!empty($_POST['get_post']) and $_SERVER["REQUEST_METHOD"] == "POST" ) {
//            $location = test_input($_POST['get_post']);
//            $sql1 = "SELECT post.*, auth.id as user_id, auth.name, auth.username, auth.addr FROM auth Inner Join post on post.user_id=auth.id ORDER BY post.id DESC LIMIT 3";
//            $result1 = $conn->query($sql1);
//            $data = array();
//            if ($result1->num_rows > 0) {
//                while($post = $result1->fetch_assoc()) {
//                    $post_id = $post['id'];
//                    $sql2 = "SELECT post_comment.*, auth.id as user_id, auth.name, auth.username, auth.addr FROM post_comment Inner Join auth on post_comment.user_id=auth.id WHERE post_comment.post_id='$post_id' ORDER BY post_comment.id DESC LIMIT 3";
//                    $result2 = $conn->query($sql2);
//                    $comments = array();
//                    if ($result2->num_rows > 0) {
//                        while($comment = $result2->fetch_assoc()) {
//                            array_push($comments, $comment);
//                        }
//                    }
//                    array_push($data, array($post,$comments));
//                }
//                echo json_encode($data);
//            }else{
//                echo array();
//            }
//        }
    }
}
