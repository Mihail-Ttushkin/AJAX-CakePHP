<?php
    $comments_string = '';
    $comments_string .= '<h4>'. __('Related Comments') . '</h4>';
    if ($comments->count()){
        $comments_string .= '<table cellpadding="0" cellspacing="0">';
        $comments_string .= '<tr>';
        $comments_string .= '<th scope="col">'. __('Id').'</th>';
        $comments_string .= '<th scope="col">'. __('Article Id').'</th>';
        $comments_string .= '<th scope="col">'. __('Body').'</th>';
        $comments_string .= '<th scope="col">'. __('Created').'</th>';
        $comments_string .= '<th scope="col">'. __('Modified').'</th>';
        $comments_string .= '<th scope="col" class="actions">'.__('Actions').'</th>';       
        $comments_string .= '</tr>';
            foreach ($comments as $comment){
                $comments_string .= '<tr>';
                $comments_string .= '<td>'.h($comment->id).'</td>';
                $comments_string .= '<td>'.h($comment->article_id).'</td>';
                $comments_string .= '<td>'.h($comment->body).'</td>';
                $comments_string .= '<td>'.h($comment->created).'</td>';
                $comments_string .= '<td>'.h($comment->modified).'</td>';
                    $comments_string .= '<td class="actions">';
                        $comments_string .= $this->Html->link(__('View'), ['controller' => 'Comments', 'action' => 'view', $comment->id]);
                        $comments_string .= $this->Html->link(__(' Edit'), ['controller' => 'Comments', 'action' => 'edit', $comment->id]);
                        $comments_string .= $this->Form->postLink(__(' Delete'), ['controller' => 'Comments', 'action' => 'delete', $comment->id], ['confirm' => __('Are you sure you want to delete # {0}?', $comment->id)]);
                    $comments_string .= '</td>';
                $comments_string .= '</tr>';
            }
        $comments_string .= '</table>';
    }
    
    $comments = $comments_string;
    
    echo json_encode(compact('comments', 'rezult'));  
?>