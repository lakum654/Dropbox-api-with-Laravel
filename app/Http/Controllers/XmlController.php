<?php

namespace App\Http\Controllers;

use DOMAttr;
use DOMDocument;
use DOMElement;
use Illuminate\Http\Request;
use App\User;
class XmlController extends Controller
{
    public function index(){
       
        $xmlData = simplexml_load_file('books.xml');

        foreach($xmlData->books as $book)
        {
            echo "Id :".$book->id;echo "<br>";
            echo "Name :".$book->name;echo "<br>";
            echo "Author :".$book->author;echo "<br>";
            echo "Price :".$book->price;echo "<br>";
            echo "<br>";
        }   
    }

    public function create()
    {
        $dom = new DOMDocument('1.0','utf-8');
        $dom->formatOutput = true;
        $root = $dom->createElement('bookstore');
        $dom->appendChild($root);

        $Name   = ['PHP','Laravel','Javascript','Xml','HTML','CSS'];
        $Author = ['John Dov','Toyllor Otwell','Denish Riches','John','Sundar','Jenny'];
        $Price  = ['100','200','350','150','230','210'];
        
        for($i=0;$i<count($Name);$i++){
            $books = $dom->createElement('books');
            $books->setAttribute('id',$i+1);
            $root->appendChild($books);

            $id = $dom->createElement('id',$i+1);
            $books->appendChild($id);
    
            $name = $dom->createElement('name',$Name[$i]);
            $books->appendChild($name);
            
            $price = $dom->createElement('price',$Price[$i]);
            $books->appendChild($price);
    
            $author = $dom->createElement('author',$Author[$i]);
            $books->appendChild($author);
        }        
          $dom->save('books.xml');
        
          $this->index();
    }


    public function db_users()
    {
        $users = User::where('role_id',14)->get();

        $dom = new DOMDocument('1.0','utf-8');
        $dom->formatOutput = true;
        
        $root = $dom->createElement('db_users');
        $dom->appendChild($root);

        foreach($users as $value)
        {
             $user = $dom->createElement('user');
             $user->setAttribute('id',$value->id);
             $root->appendChild($user);
             
             $id = $dom->createElement('id',$value->id);
             $user->appendChild($id);

             $name = $dom->createElement('name',$value->name);
             $user->appendChild($name);

             $phone = $dom->createElement('phone',$value->mobile);
             $user->appendChild($phone);

             $created_at = $dom->createElement('created_time',$value->created_at);
             $user->appendChild($created_at);
        }

         $dom->save('db_users.xml');
        //$dom->saveHTMLFile('db_users.html');
        
    }
}
