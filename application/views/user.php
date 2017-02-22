<div class="wrapper">
    <div class="row">
        <div class="small-12 columns">
            <div class="white-wrapper">
                <?php if( $users ): ?>
                <table class="content-table foundation-table">
                    <thead>
                        <tr>
                            <th><?php echo lang('user_id') ?></th>
                            <th><?php echo lang('user_username') ?></th>
                            <th><?php echo lang('user_email') ?></th>
                            <th><?php echo lang('user_group') ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        foreach( $users as $user ) {

                            if( !empty($user['firstname']) || !empty($user['surname']) ) {
                                $display_user = ((!empty($user['firstname']))?$user['firstname'].' ':'').((!empty($user['surname']))?$user['surname'].' ':'').'('.$user['username'].')';
                            } else {
                                $display_user = $user['username'];
                            }
                        ?>
                            <tr>
                                <td><?php echo html_escape($user['id']) ?></td>
                                <td><a href="<?php echo site_url('user/'.$user['id']) ?>"><i class="fa fa-pencil-square-o"></i> <?php echo html_escape($display_user) ?></a></td>
                                <td><?php echo html_escape($user['email']) ?></td>
                                <td><?php echo role_helper($user['group']) ?></td>
                            </tr>
                        <?php
                        }
                        ?>
                    </tbody>
                </table>
                <?php else: ?>
                <div class="panel no-content">
                    <h5><?php echo lang('user_no_user_h') ?></h5>
                    <p><?php echo lang('user_no_user_t') ?></p>
                </div>
                <?php endif; ?>

                <div class="clearfix" style="padding-top: 40px">
                    <a href="<?php echo site_url('user/new') ?>" class="button right no-margin"><i class="fa fa-users"></i> &nbsp; <?php echo lang('user_create_new') ?></a>
                </div>
            </div>
        </div>
    </div>
</div>