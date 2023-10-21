//using fetch rest api

let ajax_btn= document.getElementById('wp-learn-rest-api-button');
if(ajax_btn){
    ajax_btn.addEventListener('click',fetch_data);
    function fetch_data(){
        const textarea = document.getElementById('wp-learn-posts');
        let allposts = new wp.api.collections.Posts();

        allposts.fetch(
            {
                data: {"_fields": "id,title"}
            }
        ).then(response=>{
            //handle the response
            console.log(response);
            response.forEach(posts=>{
                console.log(posts);

                textarea.value += posts.id + " , " +posts.title.rendered + "\n";
            });
        })
        .catch(error=>{
            console.log('there was a problem with fetch operation', error);
        })
    }
}

/**
 * Insert Post title and content
 */
function submitPost(){
    const post_title=document.getElementById('wp-learn-post-title').value;
    const post_content=document.getElementById('wp-learn-post-content').value;

    const post= new wp.api.models.Post(
        {
            title : post_title,
            content: post_content,
            status: 'publish',
        }
    );
    post.save().done(function(post){
        alert('post saved');
    });

 }
 let submit_post_btn=document.getElementById('wp-learn-submit-post');
   if(submit_post_btn){
    submit_post_btn.addEventListener('click',submitPost);
   }

//clear posts
let clear_posts = document.getElementById('wp-learn-clear-posts');
if(clear_posts){
    clear_posts.addEventListener('click',clear_posts_fun);
    function clear_posts_fun(){
        const textarea= document.getElementById('wp-learn-posts');
        textarea.value="";
    }
}
/**
 * update post title and content
 */

let update_post_btn= document.getElementById('wp-learn-update-post');
if(update_post_btn)
{update_post_btn.addEventListener('click',updatePost);}

function updatePost(){
    const post_id = document.getElementById('wp-learn-post-update-id').value;
    const post_title = document.getElementById('wp-learn-update-post-title').value;
    const post_content = document.getElementById('wp-learn-update-post-content').value;

    const post= new wp.api.models.Post(
        {
            id: post_id,
            title: post_title,
            content: post_content
        }
    );
    post.save().done(function(post){
        alert('post updated');
    });
}
let delete_post_btn=document.getElementById('wp-learn-delete-post');
if(delete_post_btn)
{
    delete_post_btn.addEventListener('click',deletePost);
}


function deletePost(){
    const post_id=document.getElementById('wp-learn-delete-post-id').value;
    const post= new wp.api.models.Post(
        {
            id: post_id,
        }
    );
    post.destroy().done(function(post){
        alert('post deleted');
    });

}






   