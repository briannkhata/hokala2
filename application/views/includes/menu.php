<?php
// Check if page_name is 'pos'
$page_name = $this->uri->segment(1); // Adjust based on your URI structure
$is_pos_page = ($page_name === 'pos');
?>

<aside class="sidebar-wrapper <?= $is_pos_page ? 'full-screen' : ''; ?>">
    <div class="sidebar-header">
        <div class="logo-icon">
            <img src="<?= base_url(); ?>assets/images/logo-icon.png" class="logo-img" alt="">
        </div>
        <div class="logo-name flex-grow-1">
            <h5 class="mb-0">HOKALA</h5>
        </div>
        <div class="sidebar-close">
            <span class="material-icons-outlined">close</span>
        </div>
    </div>

    <?php if (!$is_pos_page): ?>
    <div class="sidebar-nav" data-simplebar="true">
        <!--navigation-->
        <ul class="metismenu" id="sidenav">
            <?php
            $role = $this->session->userdata('role');
            $this->db->where("FIND_IN_SET('$role', role) >", 0);
            $this->db->order_by('order_by', 'asc');
            $parents = $this->db->group_by('parent_id')->get('tbl_menus')->result_array();

            foreach ($parents as $pa): ?>
                <li>
                    <a href="<?= !$pa['parent'] ? '#' : base_url() . '' . $pa['url']; ?>" <?= !$pa['parent'] ? 'class="has-arrow"' : ''; ?>>
                        <div class="parent-icon"><i class="material-icons-outlined">
                                <?= $pa['parent_icon']; ?>
                            </i></div>
                        <div class="menu-title">
                            <?= $pa['parent_title']; ?>
                        </div>
                    </a>

                    <?php
                    $this->db->where("FIND_IN_SET('$role', role) >", 0);
                    $this->db->order_by('sort_order', 'asc');
                    $children = $this->db->get_where('tbl_menus', array('parent_id' => $pa['parent_id'], 'parent' => 0))->result_array();
                    ?>
                    <ul>
                        <?php foreach ($children as $child): ?>
                            <li><a href="<?= base_url(); ?><?= $child['url']; ?>"><i
                                        class="material-icons-outlined">arrow_right</i>
                                    <?= $child['title']; ?>
                                </a></li>
                        <?php endforeach; ?>
                    </ul>
                </li>
            <?php endforeach; ?>
        </ul>
    </div>
    <?php endif; ?>
</aside>

<style>
    .sidebar-wrapper.full-screen {
        width: 100%;
        height: 100vh;
        overflow: hidden;
        display: flex;
        align-items: center;
        justify-content: center;
    }
</style>
