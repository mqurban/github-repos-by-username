<?php
/*
*   WordPress Github Repos by Username Class
*/

class WP_My_Github_Repos extends WP_Widget
{

    // Create Widget
    function __construct()
    {
        parent::__construct(
            'wp_my_github_repos', // Base ID
            __('Github Repos', 'wp_my_github_repos'), // Name
            array('description' => __('A simple widget that displays a list of Github repositories for a specified username.', 'wp_my_github_repos')) // Args
        );
    }

    // Fronted Display
    public function widget($args, $instance)
    {
        // outputs the content of the widget
        $title = apply_filters('widget_title', $instance['title']);
        $username = esc_attr($instance['username']);
        $count = esc_attr($instance['count']);

        echo $args['before_widget'];

        if (!empty($title)) {
            echo $args['before_title'] . $title . $args['after_title'];
        }

        echo $this->showRepos($title, $username, $count);

        echo $args['after_widget'];
    }

    // Backend Form
    public function form($instance)
    {
        // Get the title
        if (isset($instance['title'])) {
            $title = $instance['title'];
        } else {
            $title = __('Latest Github Repos', 'wp_my_github_repos');
        }

        // Get the username
        if (isset($instance['username'])) {
            $username = $instance['username'];
        } else {
            $username = __('mqurban', 'wp_my_github_repos');
        }

        // Get the count
        if (isset($instance['count'])) {
            $count = $instance['count'];
        } else {
            $count = 5;
        }
        // outputs the options form on admin
?>

        <p>
            <label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title', 'wp_my_github_repos');  ?></label>
            <input type="text" class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" value="<?php echo esc_html($title); ?>">
        </p>
        <p>
            <label for="<?php echo $this->get_field_id('username'); ?>"><?php _e('Username', 'wp_my_github_repos');  ?></label>
            <input type="text" class="widefat" id="<?php echo $this->get_field_id('username'); ?>" name="<?php echo $this->get_field_name('username'); ?>" value="<?php echo esc_html($username); ?>">
        </p>
        <p>
            <label for="<?php echo $this->get_field_id('count'); ?>"><?php _e('Count', 'wp_my_github_repos');  ?></label>
            <input type="text" class="widefat" id="<?php echo $this->get_field_id('count'); ?>" name="<?php echo $this->get_field_name('count'); ?>" value="<?php echo esc_html($count); ?>">
        </p>

<?php
    }

    // Update Widget Values
    public function update($new_instance, $old_instance)
    {
        // Initialize the instance array with default values
        $instance = array();

        // Update values if new values are not empty
        $instance['title'] = (!empty($new_instance['title'])) ? strip_tags($new_instance['title']) : '';
        $instance['username'] = (!empty($new_instance['username'])) ? strip_tags($new_instance['username']) : '';
        $instance['count'] = (!empty($new_instance['count'])) ? strip_tags($new_instance['count']) : '';

        return $instance;
    }

    // Show Repos
    public function showRepos($title, $username, $count)
    {
        // Get Repos from Github
        $url = 'https://api.github.com/users/' . $username . '/repos?sort=created&per_page=' . $count;

        // Get Repos
        $options = array('http' => array('user_agent' => $_SERVER['HTTP_USER_AGENT']));
        $context = stream_context_create($options);
        $response = file_get_contents($url, false, $context);
        $repos = json_decode($response);

        // Show Repos
        $output = '<ul class="github-repos">';

        foreach ($repos as $repo) {
            $output .= '<li>';
            $output .= '<div class="github-repos__title">' . $repo->name . '</div>';
            $output .= '<div class="github-repos__description">' . $repo->description . '</div>';
            $output .= '<div class="github-repos__meta">';
            $output .= '<span class="github-repos__meta__item github-repos__meta__item--stars">Stars: ' . $repo->stargazers_count . '</span>';
            $output .= '<span class="github-repos__meta__item github-repos__meta__item--forks"> Forks: ' . $repo->forks_count . '</span><br>';
            $output .= '<a href="' . $repo->html_url . '" class="github-repos__meta__item github-repos__meta__item--link">View on Github</a>';
            $output .= '</div>';
            $output .= '</li>';
        }

        $output .= '</ul>';

        return $output;
    }
}
