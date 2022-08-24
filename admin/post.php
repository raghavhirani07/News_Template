<?php include "header.php"; ?>
<?php include "config.php"; ?>
<div id="admin-content">
    <div class="container">
        <div class="row">
            <div class="col-md-10">
                <h1 class="admin-heading">All Posts</h1>
            </div>
            <div class="col-md-2">
                <a class="add-new" href="add-post.php">add post</a>
            </div>
            <div class="col-md-12">
                <?php
                $limit=10;
                if(!array_key_exists('page',$_GET)){
                    $page=1;
                }
                else{
                $page=$_GET['page'];
                }
                $offset=($page - 1 )* $limit;
                if($_SESSION['role'] == 1){
                    $sql="SELECT * FROM `post`
                    INNER JOIN `category` ON `post`.`category` = `category`.`category_id`
                    INNER JOIN `user` ON `post`.`author` = `user`.`user_id`
                    ORDER BY `post`.`post_id` DESC LIMIT {$offset},{$limit}";
                }
                elseif($_SESSION['role'] == 0){
                    $sql="SELECT * FROM `post`
                    INNER JOIN `category` ON `post`.`category` = `category`.`category_id`
                    INNER JOIN `user` ON `post`.`author` = `user`.`user_id`
                    WHERE `post`.`author`={$_SESSION['id']}
                    ORDER BY `post`.`post_id` DESC LIMIT {$offset},{$limit}";
                }
                    $result=mysqli_query($conn,$sql);
                    if(mysqli_num_rows($result) > 0)
                    {
                ?>
                        <table class="content-table">
                            <thead>
                                <th>S.No.</th>
                                <th>Title</th>
                                <th>Category</th>
                                <th>Date</th>
                                <th>Author</th>
                                <th>Edit</th>
                                <th>Delete</th>
                            </thead>
                            <tbody>
                                <?php while($row=mysqli_fetch_assoc($result))
                                    {

                                ?>
                                <tr>
                                    <td class='id'><?php echo $row['post_id']; ?></td>
                                    <td><?php echo $row['title']; ?></td>
                                    <td><?php echo $row['category_name']?></td>
                                    <td><?php echo $row['post_date'] ?></td>
                                    <td><?php echo $row['first_name'].$row['last_name'];?></td>
                                    <td class='edit'><a href='update-post.php?id=<?php echo $row['post_id']; ?>'><i
                                                class='fa fa-edit'></i></a></td>
                                    <td class='delete'><a href='delete-post.php?id=<?php echo $row['post_id']; ?>'><i
                                                class='fa fa-trash-o'></i></a></td>
                                </tr>
                                <?php  } ?>
                            </tbody>
                        </table>
                <?php
                         if($_SESSION['role'] == 1){
                            $sql1="SELECT * FROM `post`";
                        }
                        elseif($_SESSION['role'] == 0){
                            $sql1="SELECT * FROM `post` WHERE  `author`={$_SESSION['id']} ";
                        }

                        $result1=mysqli_query($conn,$sql1) or die ("Query Failed ");
                            if( mysqli_num_rows($result1)>0)
                            {
                                $i=1;
                                echo "<ul class='pagination admin-pagination'>";
                                $totalrecode=mysqli_num_rows($result1);
                                $limit=10;
                                $totalpage=ceil($totalrecode/$limit);
                                if($page > 1){
                                echo '<li><a href="post.php?page='.($page - 1).'">Pre</a></li>';
                                }
                                for($i;$i <=$totalpage;$i++)
                                {
                                    if($page == $i){
                                        $active="active";
                                    }
                                    else{
                                        $active="";
                                    }
                                    echo '<li class="'.$active.'"><a href="post.php?page='.$i.' ">'.$i.'</a></li>';
                                }
                                if($page < $totalpage){
                                    echo '<li><a href="post.php?page='.($page + 1).'">next</a></li>';
                                    }
                                echo'</ul>';
                            }
                   } ?>
            </div>
        </div>
    </div>
</div>
<?php include "footer.php"; ?>