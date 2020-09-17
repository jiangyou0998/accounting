<?php

/**
 * A helper file for Dcat Admin, to provide autocomplete information to your IDE
 *
 * This file should not be included in your code, only analyzed by your IDE!
 *
 * @author jqh <841324345@qq.com>
 */
namespace Dcat\Admin {
    use Illuminate\Support\Collection;

    /**
     * @property Grid\Column|Collection name
     * @property Grid\Column|Collection version
     * @property Grid\Column|Collection alias
     * @property Grid\Column|Collection authors
     * @property Grid\Column|Collection enable
     * @property Grid\Column|Collection imported
     * @property Grid\Column|Collection config
     * @property Grid\Column|Collection require
     * @property Grid\Column|Collection require_dev
     * @property Grid\Column|Collection id
     * @property Grid\Column|Collection txt_name
     * @property Grid\Column|Collection roles
     * @property Grid\Column|Collection email
     * @property Grid\Column|Collection chr_report_name
     * @property Grid\Column|Collection int_dept
     * @property Grid\Column|Collection int_district
     * @property Grid\Column|Collection chr_type
     * @property Grid\Column|Collection chr_pocode
     * @property Grid\Column|Collection int_sort
     * @property Grid\Column|Collection cat_name
     * @property Grid\Column|Collection sort
     * @property Grid\Column|Collection status
     * @property Grid\Column|Collection start_date
     * @property Grid\Column|Collection end_date
     * @property Grid\Column|Collection product_no
     * @property Grid\Column|Collection product_name
     * @property Grid\Column|Collection base
     * @property Grid\Column|Collection min
     * @property Grid\Column|Collection default_price
     * @property Grid\Column|Collection price
     * @property Grid\Column|Collection cuttime
     * @property Grid\Column|Collection phase
     * @property Grid\Column|Collection int_phase
     * @property Grid\Column|Collection chr_name
     * @property Grid\Column|Collection int_id
     * @property Grid\Column|Collection int_cat
     * @property Grid\Column|Collection int_no
     * @property Grid\Column|Collection txt_path
     * @property Grid\Column|Collection int_user
     * @property Grid\Column|Collection date_create
     * @property Grid\Column|Collection date_modify
     * @property Grid\Column|Collection date_delete
     * @property Grid\Column|Collection date_last
     * @property Grid\Column|Collection first_path
     * @property Grid\Column|Collection int_all_shop
     * @property Grid\Column|Collection shop_list
     * @property Grid\Column|Collection item_list
     * @property Grid\Column|Collection report_name
     * @property Grid\Column|Collection num_of_day
     * @property Grid\Column|Collection int_hide
     * @property Grid\Column|Collection int_main_item
     * @property Grid\Column|Collection disabled
     * @property Grid\Column|Collection created_at
     * @property Grid\Column|Collection updated_at
     * @property Grid\Column|Collection guard_name
     * @property Grid\Column|Collection permissions
     * @property Grid\Column|Collection users
     * @property Grid\Column|Collection parent_id
     * @property Grid\Column|Collection order
     * @property Grid\Column|Collection icon
     * @property Grid\Column|Collection uri
     * @property Grid\Column|Collection user_id
     * @property Grid\Column|Collection path
     * @property Grid\Column|Collection method
     * @property Grid\Column|Collection ip
     * @property Grid\Column|Collection input
     * @property Grid\Column|Collection permission_id
     * @property Grid\Column|Collection menu_id
     * @property Grid\Column|Collection slug
     * @property Grid\Column|Collection http_method
     * @property Grid\Column|Collection http_path
     * @property Grid\Column|Collection role_id
     * @property Grid\Column|Collection username
     * @property Grid\Column|Collection password
     * @property Grid\Column|Collection avatar
     * @property Grid\Column|Collection remember_token
     * @property Grid\Column|Collection connection
     * @property Grid\Column|Collection queue
     * @property Grid\Column|Collection payload
     * @property Grid\Column|Collection exception
     * @property Grid\Column|Collection failed_at
     * @property Grid\Column|Collection model_type
     * @property Grid\Column|Collection model_id
     * @property Grid\Column|Collection token
     * @property Grid\Column|Collection shop_group_id
     * @property Grid\Column|Collection check_id
     * @property Grid\Column|Collection time
     * @property Grid\Column|Collection weekday
     * @property Grid\Column|Collection r_order_id
     * @property Grid\Column|Collection qty
     * @property Grid\Column|Collection orderdates
     * @property Grid\Column|Collection txt_dept
     * @property Grid\Column|Collection bl_isvalid
     * @property Grid\Column|Collection int_user_id
     * @property Grid\Column|Collection int_dept_id
     * @property Grid\Column|Collection chr_tel
     * @property Grid\Column|Collection chr_fax
     * @property Grid\Column|Collection chr_address
     * @property Grid\Column|Collection chr_eng_address
     * @property Grid\Column|Collection int_area
     * @property Grid\Column|Collection chr_code
     * @property Grid\Column|Collection chr_oper_time
     * @property Grid\Column|Collection is_sample
     * @property Grid\Column|Collection sample_path
     * @property Grid\Column|Collection is_multi_print
     * @property Grid\Column|Collection int_brand_id
     * @property Grid\Column|Collection int_form_id
     * @property Grid\Column|Collection main_id
     * @property Grid\Column|Collection txt_ori_doc
     * @property Grid\Column|Collection state_cent
     * @property Grid\Column|Collection state_logs
     * @property Grid\Column|Collection int_shop
     * @property Grid\Column|Collection group_id
     * @property Grid\Column|Collection author
     * @property Grid\Column|Collection txt_ori_file
     * @property Grid\Column|Collection txt_ori_name
     * @property Grid\Column|Collection txt_ori_url
     * @property Grid\Column|Collection state_dept
     * @property Grid\Column|Collection int_notice_id
     * @property Grid\Column|Collection order_date
     * @property Grid\Column|Collection int_branch
     * @property Grid\Column|Collection int_form
     * @property Grid\Column|Collection int_qty
     * @property Grid\Column|Collection bl_email
     * @property Grid\Column|Collection chr_ip
     * @property Grid\Column|Collection int_po_no
     * @property Grid\Column|Collection chr_prefix
     * @property Grid\Column|Collection chr_email
     * @property Grid\Column|Collection int_group_id
     * @property Grid\Column|Collection int_menu_id
     * @property Grid\Column|Collection int_area_id
     * @property Grid\Column|Collection txt_login
     * @property Grid\Column|Collection txt_password
     * @property Grid\Column|Collection chr_mobile
     * @property Grid\Column|Collection chr_officephone
     * @property Grid\Column|Collection chr_title
     * @property Grid\Column|Collection chr_outlet
     * @property Grid\Column|Collection chr_sub
     * @property Grid\Column|Collection chr_ename
     * @property Grid\Column|Collection int_boss
     * @property Grid\Column|Collection int_dis
     * @property Grid\Column|Collection chr_sap
     * @property Grid\Column|Collection chr_visible
     * @property Grid\Column|Collection int_force
     * @property Grid\Column|Collection type
     * @property Grid\Column|Collection email_verified_at
     * @property Grid\Column|Collection operate_user_id
     * @property Grid\Column|Collection shop_id
     * @property Grid\Column|Collection product_id
     * @property Grid\Column|Collection chr_phase
     * @property Grid\Column|Collection po_no
     * @property Grid\Column|Collection dept
     * @property Grid\Column|Collection insert_date
     * @property Grid\Column|Collection qty_received
     * @property Grid\Column|Collection received_date
     * @property Grid\Column|Collection reason
     * @property Grid\Column|Collection deli_date
     * @property Grid\Column|Collection int_page
     * @property Grid\Column|Collection group_name
     * @property Grid\Column|Collection cat_id
     * @property Grid\Column|Collection short_name
     * @property Grid\Column|Collection last_modify
     * @property Grid\Column|Collection sampledate
     * @property Grid\Column|Collection sample_id
     * @property Grid\Column|Collection unit_id
     * @property Grid\Column|Collection image
     * @property Grid\Column|Collection canordertime
     * @property Grid\Column|Collection unit_name
     *
     * @method Grid\Column|Collection name(string $label = null)
     * @method Grid\Column|Collection version(string $label = null)
     * @method Grid\Column|Collection alias(string $label = null)
     * @method Grid\Column|Collection authors(string $label = null)
     * @method Grid\Column|Collection enable(string $label = null)
     * @method Grid\Column|Collection imported(string $label = null)
     * @method Grid\Column|Collection config(string $label = null)
     * @method Grid\Column|Collection require(string $label = null)
     * @method Grid\Column|Collection require_dev(string $label = null)
     * @method Grid\Column|Collection id(string $label = null)
     * @method Grid\Column|Collection txt_name(string $label = null)
     * @method Grid\Column|Collection roles(string $label = null)
     * @method Grid\Column|Collection email(string $label = null)
     * @method Grid\Column|Collection chr_report_name(string $label = null)
     * @method Grid\Column|Collection int_dept(string $label = null)
     * @method Grid\Column|Collection int_district(string $label = null)
     * @method Grid\Column|Collection chr_type(string $label = null)
     * @method Grid\Column|Collection chr_pocode(string $label = null)
     * @method Grid\Column|Collection int_sort(string $label = null)
     * @method Grid\Column|Collection cat_name(string $label = null)
     * @method Grid\Column|Collection sort(string $label = null)
     * @method Grid\Column|Collection status(string $label = null)
     * @method Grid\Column|Collection start_date(string $label = null)
     * @method Grid\Column|Collection end_date(string $label = null)
     * @method Grid\Column|Collection product_no(string $label = null)
     * @method Grid\Column|Collection product_name(string $label = null)
     * @method Grid\Column|Collection base(string $label = null)
     * @method Grid\Column|Collection min(string $label = null)
     * @method Grid\Column|Collection default_price(string $label = null)
     * @method Grid\Column|Collection price(string $label = null)
     * @method Grid\Column|Collection cuttime(string $label = null)
     * @method Grid\Column|Collection phase(string $label = null)
     * @method Grid\Column|Collection int_phase(string $label = null)
     * @method Grid\Column|Collection chr_name(string $label = null)
     * @method Grid\Column|Collection int_id(string $label = null)
     * @method Grid\Column|Collection int_cat(string $label = null)
     * @method Grid\Column|Collection int_no(string $label = null)
     * @method Grid\Column|Collection txt_path(string $label = null)
     * @method Grid\Column|Collection int_user(string $label = null)
     * @method Grid\Column|Collection date_create(string $label = null)
     * @method Grid\Column|Collection date_modify(string $label = null)
     * @method Grid\Column|Collection date_delete(string $label = null)
     * @method Grid\Column|Collection date_last(string $label = null)
     * @method Grid\Column|Collection first_path(string $label = null)
     * @method Grid\Column|Collection int_all_shop(string $label = null)
     * @method Grid\Column|Collection shop_list(string $label = null)
     * @method Grid\Column|Collection item_list(string $label = null)
     * @method Grid\Column|Collection report_name(string $label = null)
     * @method Grid\Column|Collection num_of_day(string $label = null)
     * @method Grid\Column|Collection int_hide(string $label = null)
     * @method Grid\Column|Collection int_main_item(string $label = null)
     * @method Grid\Column|Collection disabled(string $label = null)
     * @method Grid\Column|Collection created_at(string $label = null)
     * @method Grid\Column|Collection updated_at(string $label = null)
     * @method Grid\Column|Collection guard_name(string $label = null)
     * @method Grid\Column|Collection permissions(string $label = null)
     * @method Grid\Column|Collection users(string $label = null)
     * @method Grid\Column|Collection parent_id(string $label = null)
     * @method Grid\Column|Collection order(string $label = null)
     * @method Grid\Column|Collection icon(string $label = null)
     * @method Grid\Column|Collection uri(string $label = null)
     * @method Grid\Column|Collection user_id(string $label = null)
     * @method Grid\Column|Collection path(string $label = null)
     * @method Grid\Column|Collection method(string $label = null)
     * @method Grid\Column|Collection ip(string $label = null)
     * @method Grid\Column|Collection input(string $label = null)
     * @method Grid\Column|Collection permission_id(string $label = null)
     * @method Grid\Column|Collection menu_id(string $label = null)
     * @method Grid\Column|Collection slug(string $label = null)
     * @method Grid\Column|Collection http_method(string $label = null)
     * @method Grid\Column|Collection http_path(string $label = null)
     * @method Grid\Column|Collection role_id(string $label = null)
     * @method Grid\Column|Collection username(string $label = null)
     * @method Grid\Column|Collection password(string $label = null)
     * @method Grid\Column|Collection avatar(string $label = null)
     * @method Grid\Column|Collection remember_token(string $label = null)
     * @method Grid\Column|Collection connection(string $label = null)
     * @method Grid\Column|Collection queue(string $label = null)
     * @method Grid\Column|Collection payload(string $label = null)
     * @method Grid\Column|Collection exception(string $label = null)
     * @method Grid\Column|Collection failed_at(string $label = null)
     * @method Grid\Column|Collection model_type(string $label = null)
     * @method Grid\Column|Collection model_id(string $label = null)
     * @method Grid\Column|Collection token(string $label = null)
     * @method Grid\Column|Collection shop_group_id(string $label = null)
     * @method Grid\Column|Collection check_id(string $label = null)
     * @method Grid\Column|Collection time(string $label = null)
     * @method Grid\Column|Collection weekday(string $label = null)
     * @method Grid\Column|Collection r_order_id(string $label = null)
     * @method Grid\Column|Collection qty(string $label = null)
     * @method Grid\Column|Collection orderdates(string $label = null)
     * @method Grid\Column|Collection txt_dept(string $label = null)
     * @method Grid\Column|Collection bl_isvalid(string $label = null)
     * @method Grid\Column|Collection int_user_id(string $label = null)
     * @method Grid\Column|Collection int_dept_id(string $label = null)
     * @method Grid\Column|Collection chr_tel(string $label = null)
     * @method Grid\Column|Collection chr_fax(string $label = null)
     * @method Grid\Column|Collection chr_address(string $label = null)
     * @method Grid\Column|Collection chr_eng_address(string $label = null)
     * @method Grid\Column|Collection int_area(string $label = null)
     * @method Grid\Column|Collection chr_code(string $label = null)
     * @method Grid\Column|Collection chr_oper_time(string $label = null)
     * @method Grid\Column|Collection is_sample(string $label = null)
     * @method Grid\Column|Collection sample_path(string $label = null)
     * @method Grid\Column|Collection is_multi_print(string $label = null)
     * @method Grid\Column|Collection int_brand_id(string $label = null)
     * @method Grid\Column|Collection int_form_id(string $label = null)
     * @method Grid\Column|Collection main_id(string $label = null)
     * @method Grid\Column|Collection txt_ori_doc(string $label = null)
     * @method Grid\Column|Collection state_cent(string $label = null)
     * @method Grid\Column|Collection state_logs(string $label = null)
     * @method Grid\Column|Collection int_shop(string $label = null)
     * @method Grid\Column|Collection group_id(string $label = null)
     * @method Grid\Column|Collection author(string $label = null)
     * @method Grid\Column|Collection txt_ori_file(string $label = null)
     * @method Grid\Column|Collection txt_ori_name(string $label = null)
     * @method Grid\Column|Collection txt_ori_url(string $label = null)
     * @method Grid\Column|Collection state_dept(string $label = null)
     * @method Grid\Column|Collection int_notice_id(string $label = null)
     * @method Grid\Column|Collection order_date(string $label = null)
     * @method Grid\Column|Collection int_branch(string $label = null)
     * @method Grid\Column|Collection int_form(string $label = null)
     * @method Grid\Column|Collection int_qty(string $label = null)
     * @method Grid\Column|Collection bl_email(string $label = null)
     * @method Grid\Column|Collection chr_ip(string $label = null)
     * @method Grid\Column|Collection int_po_no(string $label = null)
     * @method Grid\Column|Collection chr_prefix(string $label = null)
     * @method Grid\Column|Collection chr_email(string $label = null)
     * @method Grid\Column|Collection int_group_id(string $label = null)
     * @method Grid\Column|Collection int_menu_id(string $label = null)
     * @method Grid\Column|Collection int_area_id(string $label = null)
     * @method Grid\Column|Collection txt_login(string $label = null)
     * @method Grid\Column|Collection txt_password(string $label = null)
     * @method Grid\Column|Collection chr_mobile(string $label = null)
     * @method Grid\Column|Collection chr_officephone(string $label = null)
     * @method Grid\Column|Collection chr_title(string $label = null)
     * @method Grid\Column|Collection chr_outlet(string $label = null)
     * @method Grid\Column|Collection chr_sub(string $label = null)
     * @method Grid\Column|Collection chr_ename(string $label = null)
     * @method Grid\Column|Collection int_boss(string $label = null)
     * @method Grid\Column|Collection int_dis(string $label = null)
     * @method Grid\Column|Collection chr_sap(string $label = null)
     * @method Grid\Column|Collection chr_visible(string $label = null)
     * @method Grid\Column|Collection int_force(string $label = null)
     * @method Grid\Column|Collection type(string $label = null)
     * @method Grid\Column|Collection email_verified_at(string $label = null)
     * @method Grid\Column|Collection operate_user_id(string $label = null)
     * @method Grid\Column|Collection shop_id(string $label = null)
     * @method Grid\Column|Collection product_id(string $label = null)
     * @method Grid\Column|Collection chr_phase(string $label = null)
     * @method Grid\Column|Collection po_no(string $label = null)
     * @method Grid\Column|Collection dept(string $label = null)
     * @method Grid\Column|Collection insert_date(string $label = null)
     * @method Grid\Column|Collection qty_received(string $label = null)
     * @method Grid\Column|Collection received_date(string $label = null)
     * @method Grid\Column|Collection reason(string $label = null)
     * @method Grid\Column|Collection deli_date(string $label = null)
     * @method Grid\Column|Collection int_page(string $label = null)
     * @method Grid\Column|Collection group_name(string $label = null)
     * @method Grid\Column|Collection cat_id(string $label = null)
     * @method Grid\Column|Collection short_name(string $label = null)
     * @method Grid\Column|Collection last_modify(string $label = null)
     * @method Grid\Column|Collection sampledate(string $label = null)
     * @method Grid\Column|Collection sample_id(string $label = null)
     * @method Grid\Column|Collection unit_id(string $label = null)
     * @method Grid\Column|Collection image(string $label = null)
     * @method Grid\Column|Collection canordertime(string $label = null)
     * @method Grid\Column|Collection unit_name(string $label = null)
     */
    class Grid {}

    class MiniGrid extends Grid {}

    /**
     * @property Show\Field|Collection name
     * @property Show\Field|Collection version
     * @property Show\Field|Collection alias
     * @property Show\Field|Collection authors
     * @property Show\Field|Collection enable
     * @property Show\Field|Collection imported
     * @property Show\Field|Collection config
     * @property Show\Field|Collection require
     * @property Show\Field|Collection require_dev
     * @property Show\Field|Collection id
     * @property Show\Field|Collection txt_name
     * @property Show\Field|Collection roles
     * @property Show\Field|Collection email
     * @property Show\Field|Collection chr_report_name
     * @property Show\Field|Collection int_dept
     * @property Show\Field|Collection int_district
     * @property Show\Field|Collection chr_type
     * @property Show\Field|Collection chr_pocode
     * @property Show\Field|Collection int_sort
     * @property Show\Field|Collection cat_name
     * @property Show\Field|Collection sort
     * @property Show\Field|Collection status
     * @property Show\Field|Collection start_date
     * @property Show\Field|Collection end_date
     * @property Show\Field|Collection product_no
     * @property Show\Field|Collection product_name
     * @property Show\Field|Collection base
     * @property Show\Field|Collection min
     * @property Show\Field|Collection default_price
     * @property Show\Field|Collection price
     * @property Show\Field|Collection cuttime
     * @property Show\Field|Collection phase
     * @property Show\Field|Collection int_phase
     * @property Show\Field|Collection chr_name
     * @property Show\Field|Collection int_id
     * @property Show\Field|Collection int_cat
     * @property Show\Field|Collection int_no
     * @property Show\Field|Collection txt_path
     * @property Show\Field|Collection int_user
     * @property Show\Field|Collection date_create
     * @property Show\Field|Collection date_modify
     * @property Show\Field|Collection date_delete
     * @property Show\Field|Collection date_last
     * @property Show\Field|Collection first_path
     * @property Show\Field|Collection int_all_shop
     * @property Show\Field|Collection shop_list
     * @property Show\Field|Collection item_list
     * @property Show\Field|Collection report_name
     * @property Show\Field|Collection num_of_day
     * @property Show\Field|Collection int_hide
     * @property Show\Field|Collection int_main_item
     * @property Show\Field|Collection disabled
     * @property Show\Field|Collection created_at
     * @property Show\Field|Collection updated_at
     * @property Show\Field|Collection guard_name
     * @property Show\Field|Collection permissions
     * @property Show\Field|Collection users
     * @property Show\Field|Collection parent_id
     * @property Show\Field|Collection order
     * @property Show\Field|Collection icon
     * @property Show\Field|Collection uri
     * @property Show\Field|Collection user_id
     * @property Show\Field|Collection path
     * @property Show\Field|Collection method
     * @property Show\Field|Collection ip
     * @property Show\Field|Collection input
     * @property Show\Field|Collection permission_id
     * @property Show\Field|Collection menu_id
     * @property Show\Field|Collection slug
     * @property Show\Field|Collection http_method
     * @property Show\Field|Collection http_path
     * @property Show\Field|Collection role_id
     * @property Show\Field|Collection username
     * @property Show\Field|Collection password
     * @property Show\Field|Collection avatar
     * @property Show\Field|Collection remember_token
     * @property Show\Field|Collection connection
     * @property Show\Field|Collection queue
     * @property Show\Field|Collection payload
     * @property Show\Field|Collection exception
     * @property Show\Field|Collection failed_at
     * @property Show\Field|Collection model_type
     * @property Show\Field|Collection model_id
     * @property Show\Field|Collection token
     * @property Show\Field|Collection shop_group_id
     * @property Show\Field|Collection check_id
     * @property Show\Field|Collection time
     * @property Show\Field|Collection weekday
     * @property Show\Field|Collection r_order_id
     * @property Show\Field|Collection qty
     * @property Show\Field|Collection orderdates
     * @property Show\Field|Collection txt_dept
     * @property Show\Field|Collection bl_isvalid
     * @property Show\Field|Collection int_user_id
     * @property Show\Field|Collection int_dept_id
     * @property Show\Field|Collection chr_tel
     * @property Show\Field|Collection chr_fax
     * @property Show\Field|Collection chr_address
     * @property Show\Field|Collection chr_eng_address
     * @property Show\Field|Collection int_area
     * @property Show\Field|Collection chr_code
     * @property Show\Field|Collection chr_oper_time
     * @property Show\Field|Collection is_sample
     * @property Show\Field|Collection sample_path
     * @property Show\Field|Collection is_multi_print
     * @property Show\Field|Collection int_brand_id
     * @property Show\Field|Collection int_form_id
     * @property Show\Field|Collection main_id
     * @property Show\Field|Collection txt_ori_doc
     * @property Show\Field|Collection state_cent
     * @property Show\Field|Collection state_logs
     * @property Show\Field|Collection int_shop
     * @property Show\Field|Collection group_id
     * @property Show\Field|Collection author
     * @property Show\Field|Collection txt_ori_file
     * @property Show\Field|Collection txt_ori_name
     * @property Show\Field|Collection txt_ori_url
     * @property Show\Field|Collection state_dept
     * @property Show\Field|Collection int_notice_id
     * @property Show\Field|Collection order_date
     * @property Show\Field|Collection int_branch
     * @property Show\Field|Collection int_form
     * @property Show\Field|Collection int_qty
     * @property Show\Field|Collection bl_email
     * @property Show\Field|Collection chr_ip
     * @property Show\Field|Collection int_po_no
     * @property Show\Field|Collection chr_prefix
     * @property Show\Field|Collection chr_email
     * @property Show\Field|Collection int_group_id
     * @property Show\Field|Collection int_menu_id
     * @property Show\Field|Collection int_area_id
     * @property Show\Field|Collection txt_login
     * @property Show\Field|Collection txt_password
     * @property Show\Field|Collection chr_mobile
     * @property Show\Field|Collection chr_officephone
     * @property Show\Field|Collection chr_title
     * @property Show\Field|Collection chr_outlet
     * @property Show\Field|Collection chr_sub
     * @property Show\Field|Collection chr_ename
     * @property Show\Field|Collection int_boss
     * @property Show\Field|Collection int_dis
     * @property Show\Field|Collection chr_sap
     * @property Show\Field|Collection chr_visible
     * @property Show\Field|Collection int_force
     * @property Show\Field|Collection type
     * @property Show\Field|Collection email_verified_at
     * @property Show\Field|Collection operate_user_id
     * @property Show\Field|Collection shop_id
     * @property Show\Field|Collection product_id
     * @property Show\Field|Collection chr_phase
     * @property Show\Field|Collection po_no
     * @property Show\Field|Collection dept
     * @property Show\Field|Collection insert_date
     * @property Show\Field|Collection qty_received
     * @property Show\Field|Collection received_date
     * @property Show\Field|Collection reason
     * @property Show\Field|Collection deli_date
     * @property Show\Field|Collection int_page
     * @property Show\Field|Collection group_name
     * @property Show\Field|Collection cat_id
     * @property Show\Field|Collection short_name
     * @property Show\Field|Collection last_modify
     * @property Show\Field|Collection sampledate
     * @property Show\Field|Collection sample_id
     * @property Show\Field|Collection unit_id
     * @property Show\Field|Collection image
     * @property Show\Field|Collection canordertime
     * @property Show\Field|Collection unit_name
     *
     * @method Show\Field|Collection name(string $label = null)
     * @method Show\Field|Collection version(string $label = null)
     * @method Show\Field|Collection alias(string $label = null)
     * @method Show\Field|Collection authors(string $label = null)
     * @method Show\Field|Collection enable(string $label = null)
     * @method Show\Field|Collection imported(string $label = null)
     * @method Show\Field|Collection config(string $label = null)
     * @method Show\Field|Collection require(string $label = null)
     * @method Show\Field|Collection require_dev(string $label = null)
     * @method Show\Field|Collection id(string $label = null)
     * @method Show\Field|Collection txt_name(string $label = null)
     * @method Show\Field|Collection roles(string $label = null)
     * @method Show\Field|Collection email(string $label = null)
     * @method Show\Field|Collection chr_report_name(string $label = null)
     * @method Show\Field|Collection int_dept(string $label = null)
     * @method Show\Field|Collection int_district(string $label = null)
     * @method Show\Field|Collection chr_type(string $label = null)
     * @method Show\Field|Collection chr_pocode(string $label = null)
     * @method Show\Field|Collection int_sort(string $label = null)
     * @method Show\Field|Collection cat_name(string $label = null)
     * @method Show\Field|Collection sort(string $label = null)
     * @method Show\Field|Collection status(string $label = null)
     * @method Show\Field|Collection start_date(string $label = null)
     * @method Show\Field|Collection end_date(string $label = null)
     * @method Show\Field|Collection product_no(string $label = null)
     * @method Show\Field|Collection product_name(string $label = null)
     * @method Show\Field|Collection base(string $label = null)
     * @method Show\Field|Collection min(string $label = null)
     * @method Show\Field|Collection default_price(string $label = null)
     * @method Show\Field|Collection price(string $label = null)
     * @method Show\Field|Collection cuttime(string $label = null)
     * @method Show\Field|Collection phase(string $label = null)
     * @method Show\Field|Collection int_phase(string $label = null)
     * @method Show\Field|Collection chr_name(string $label = null)
     * @method Show\Field|Collection int_id(string $label = null)
     * @method Show\Field|Collection int_cat(string $label = null)
     * @method Show\Field|Collection int_no(string $label = null)
     * @method Show\Field|Collection txt_path(string $label = null)
     * @method Show\Field|Collection int_user(string $label = null)
     * @method Show\Field|Collection date_create(string $label = null)
     * @method Show\Field|Collection date_modify(string $label = null)
     * @method Show\Field|Collection date_delete(string $label = null)
     * @method Show\Field|Collection date_last(string $label = null)
     * @method Show\Field|Collection first_path(string $label = null)
     * @method Show\Field|Collection int_all_shop(string $label = null)
     * @method Show\Field|Collection shop_list(string $label = null)
     * @method Show\Field|Collection item_list(string $label = null)
     * @method Show\Field|Collection report_name(string $label = null)
     * @method Show\Field|Collection num_of_day(string $label = null)
     * @method Show\Field|Collection int_hide(string $label = null)
     * @method Show\Field|Collection int_main_item(string $label = null)
     * @method Show\Field|Collection disabled(string $label = null)
     * @method Show\Field|Collection created_at(string $label = null)
     * @method Show\Field|Collection updated_at(string $label = null)
     * @method Show\Field|Collection guard_name(string $label = null)
     * @method Show\Field|Collection permissions(string $label = null)
     * @method Show\Field|Collection users(string $label = null)
     * @method Show\Field|Collection parent_id(string $label = null)
     * @method Show\Field|Collection order(string $label = null)
     * @method Show\Field|Collection icon(string $label = null)
     * @method Show\Field|Collection uri(string $label = null)
     * @method Show\Field|Collection user_id(string $label = null)
     * @method Show\Field|Collection path(string $label = null)
     * @method Show\Field|Collection method(string $label = null)
     * @method Show\Field|Collection ip(string $label = null)
     * @method Show\Field|Collection input(string $label = null)
     * @method Show\Field|Collection permission_id(string $label = null)
     * @method Show\Field|Collection menu_id(string $label = null)
     * @method Show\Field|Collection slug(string $label = null)
     * @method Show\Field|Collection http_method(string $label = null)
     * @method Show\Field|Collection http_path(string $label = null)
     * @method Show\Field|Collection role_id(string $label = null)
     * @method Show\Field|Collection username(string $label = null)
     * @method Show\Field|Collection password(string $label = null)
     * @method Show\Field|Collection avatar(string $label = null)
     * @method Show\Field|Collection remember_token(string $label = null)
     * @method Show\Field|Collection connection(string $label = null)
     * @method Show\Field|Collection queue(string $label = null)
     * @method Show\Field|Collection payload(string $label = null)
     * @method Show\Field|Collection exception(string $label = null)
     * @method Show\Field|Collection failed_at(string $label = null)
     * @method Show\Field|Collection model_type(string $label = null)
     * @method Show\Field|Collection model_id(string $label = null)
     * @method Show\Field|Collection token(string $label = null)
     * @method Show\Field|Collection shop_group_id(string $label = null)
     * @method Show\Field|Collection check_id(string $label = null)
     * @method Show\Field|Collection time(string $label = null)
     * @method Show\Field|Collection weekday(string $label = null)
     * @method Show\Field|Collection r_order_id(string $label = null)
     * @method Show\Field|Collection qty(string $label = null)
     * @method Show\Field|Collection orderdates(string $label = null)
     * @method Show\Field|Collection txt_dept(string $label = null)
     * @method Show\Field|Collection bl_isvalid(string $label = null)
     * @method Show\Field|Collection int_user_id(string $label = null)
     * @method Show\Field|Collection int_dept_id(string $label = null)
     * @method Show\Field|Collection chr_tel(string $label = null)
     * @method Show\Field|Collection chr_fax(string $label = null)
     * @method Show\Field|Collection chr_address(string $label = null)
     * @method Show\Field|Collection chr_eng_address(string $label = null)
     * @method Show\Field|Collection int_area(string $label = null)
     * @method Show\Field|Collection chr_code(string $label = null)
     * @method Show\Field|Collection chr_oper_time(string $label = null)
     * @method Show\Field|Collection is_sample(string $label = null)
     * @method Show\Field|Collection sample_path(string $label = null)
     * @method Show\Field|Collection is_multi_print(string $label = null)
     * @method Show\Field|Collection int_brand_id(string $label = null)
     * @method Show\Field|Collection int_form_id(string $label = null)
     * @method Show\Field|Collection main_id(string $label = null)
     * @method Show\Field|Collection txt_ori_doc(string $label = null)
     * @method Show\Field|Collection state_cent(string $label = null)
     * @method Show\Field|Collection state_logs(string $label = null)
     * @method Show\Field|Collection int_shop(string $label = null)
     * @method Show\Field|Collection group_id(string $label = null)
     * @method Show\Field|Collection author(string $label = null)
     * @method Show\Field|Collection txt_ori_file(string $label = null)
     * @method Show\Field|Collection txt_ori_name(string $label = null)
     * @method Show\Field|Collection txt_ori_url(string $label = null)
     * @method Show\Field|Collection state_dept(string $label = null)
     * @method Show\Field|Collection int_notice_id(string $label = null)
     * @method Show\Field|Collection order_date(string $label = null)
     * @method Show\Field|Collection int_branch(string $label = null)
     * @method Show\Field|Collection int_form(string $label = null)
     * @method Show\Field|Collection int_qty(string $label = null)
     * @method Show\Field|Collection bl_email(string $label = null)
     * @method Show\Field|Collection chr_ip(string $label = null)
     * @method Show\Field|Collection int_po_no(string $label = null)
     * @method Show\Field|Collection chr_prefix(string $label = null)
     * @method Show\Field|Collection chr_email(string $label = null)
     * @method Show\Field|Collection int_group_id(string $label = null)
     * @method Show\Field|Collection int_menu_id(string $label = null)
     * @method Show\Field|Collection int_area_id(string $label = null)
     * @method Show\Field|Collection txt_login(string $label = null)
     * @method Show\Field|Collection txt_password(string $label = null)
     * @method Show\Field|Collection chr_mobile(string $label = null)
     * @method Show\Field|Collection chr_officephone(string $label = null)
     * @method Show\Field|Collection chr_title(string $label = null)
     * @method Show\Field|Collection chr_outlet(string $label = null)
     * @method Show\Field|Collection chr_sub(string $label = null)
     * @method Show\Field|Collection chr_ename(string $label = null)
     * @method Show\Field|Collection int_boss(string $label = null)
     * @method Show\Field|Collection int_dis(string $label = null)
     * @method Show\Field|Collection chr_sap(string $label = null)
     * @method Show\Field|Collection chr_visible(string $label = null)
     * @method Show\Field|Collection int_force(string $label = null)
     * @method Show\Field|Collection type(string $label = null)
     * @method Show\Field|Collection email_verified_at(string $label = null)
     * @method Show\Field|Collection operate_user_id(string $label = null)
     * @method Show\Field|Collection shop_id(string $label = null)
     * @method Show\Field|Collection product_id(string $label = null)
     * @method Show\Field|Collection chr_phase(string $label = null)
     * @method Show\Field|Collection po_no(string $label = null)
     * @method Show\Field|Collection dept(string $label = null)
     * @method Show\Field|Collection insert_date(string $label = null)
     * @method Show\Field|Collection qty_received(string $label = null)
     * @method Show\Field|Collection received_date(string $label = null)
     * @method Show\Field|Collection reason(string $label = null)
     * @method Show\Field|Collection deli_date(string $label = null)
     * @method Show\Field|Collection int_page(string $label = null)
     * @method Show\Field|Collection group_name(string $label = null)
     * @method Show\Field|Collection cat_id(string $label = null)
     * @method Show\Field|Collection short_name(string $label = null)
     * @method Show\Field|Collection last_modify(string $label = null)
     * @method Show\Field|Collection sampledate(string $label = null)
     * @method Show\Field|Collection sample_id(string $label = null)
     * @method Show\Field|Collection unit_id(string $label = null)
     * @method Show\Field|Collection image(string $label = null)
     * @method Show\Field|Collection canordertime(string $label = null)
     * @method Show\Field|Collection unit_name(string $label = null)
     */
    class Show {}

    /**
     * @method \Dcat\Admin\Form\Field\Button button(...$params)
     */
    class Form {}

}

namespace Dcat\Admin\Grid {
    /**
     
     */
    class Column {}

    /**
     
     */
    class Filter {}
}

namespace Dcat\Admin\Show {
    /**
     
     */
    class Field {}
}
