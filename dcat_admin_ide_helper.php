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
     * @property Grid\Column|Collection id
     * @property Grid\Column|Collection username
     * @property Grid\Column|Collection name
     * @property Grid\Column|Collection roles
     * @property Grid\Column|Collection permissions
     * @property Grid\Column|Collection created_at
     * @property Grid\Column|Collection updated_at
     * @property Grid\Column|Collection avatar
     * @property Grid\Column|Collection user
     * @property Grid\Column|Collection method
     * @property Grid\Column|Collection path
     * @property Grid\Column|Collection ip
     * @property Grid\Column|Collection input
     * @property Grid\Column|Collection slug
     * @property Grid\Column|Collection version
     * @property Grid\Column|Collection alias
     * @property Grid\Column|Collection authors
     * @property Grid\Column|Collection enable
     * @property Grid\Column|Collection imported
     * @property Grid\Column|Collection config
     * @property Grid\Column|Collection require
     * @property Grid\Column|Collection require_dev
     * @property Grid\Column|Collection int_id
     * @property Grid\Column|Collection txt_login
     * @property Grid\Column|Collection txt_name
     * @property Grid\Column|Collection txt_password
     * @property Grid\Column|Collection chr_report_name
     * @property Grid\Column|Collection int_dept
     * @property Grid\Column|Collection int_district
     * @property Grid\Column|Collection chr_mobile
     * @property Grid\Column|Collection chr_officephone
     * @property Grid\Column|Collection chr_email
     * @property Grid\Column|Collection chr_type
     * @property Grid\Column|Collection chr_title
     * @property Grid\Column|Collection chr_fax
     * @property Grid\Column|Collection chr_outlet
     * @property Grid\Column|Collection chr_sub
     * @property Grid\Column|Collection chr_ename
     * @property Grid\Column|Collection int_boss
     * @property Grid\Column|Collection int_dis
     * @property Grid\Column|Collection chr_sap
     * @property Grid\Column|Collection int_no
     * @property Grid\Column|Collection chr_visible
     * @property Grid\Column|Collection int_force
     * @property Grid\Column|Collection chr_pocode
     * @property Grid\Column|Collection int_sort
     * @property Grid\Column|Collection chr_no
     * @property Grid\Column|Collection chr_name
     * @property Grid\Column|Collection int_base
     * @property Grid\Column|Collection int_min
     * @property Grid\Column|Collection int_default_price
     * @property Grid\Column|Collection chr_cuttime
     * @property Grid\Column|Collection int_phase
     * @property Grid\Column|Collection status
     * @property Grid\Column|Collection prices
     * @property Grid\Column|Collection int_group
     * @property Grid\Column|Collection int_unit
     * @property Grid\Column|Collection chr_sap_2
     * @property Grid\Column|Collection int_unit_2
     * @property Grid\Column|Collection chr_image
     * @property Grid\Column|Collection txt_detail_1
     * @property Grid\Column|Collection txt_detail_2
     * @property Grid\Column|Collection txt_detail_3
     * @property Grid\Column|Collection last_modify
     * @property Grid\Column|Collection chr_canordertime
     * @property Grid\Column|Collection int_cat
     * @property Grid\Column|Collection txt_path
     * @property Grid\Column|Collection int_user
     * @property Grid\Column|Collection date_create
     * @property Grid\Column|Collection date_modify
     * @property Grid\Column|Collection date_delete
     * @property Grid\Column|Collection date_last
     * @property Grid\Column|Collection first_path
     * @property Grid\Column|Collection int_num_of_day
     * @property Grid\Column|Collection sort
     * @property Grid\Column|Collection parent_id
     * @property Grid\Column|Collection order
     * @property Grid\Column|Collection icon
     * @property Grid\Column|Collection uri
     * @property Grid\Column|Collection user_id
     * @property Grid\Column|Collection permission_id
     * @property Grid\Column|Collection menu_id
     * @property Grid\Column|Collection http_method
     * @property Grid\Column|Collection http_path
     * @property Grid\Column|Collection role_id
     * @property Grid\Column|Collection password
     * @property Grid\Column|Collection remember_token
     * @property Grid\Column|Collection bio
     * @property Grid\Column|Collection painter_id
     * @property Grid\Column|Collection body
     * @property Grid\Column|Collection completed_at
     * @property Grid\Column|Collection connection
     * @property Grid\Column|Collection queue
     * @property Grid\Column|Collection payload
     * @property Grid\Column|Collection exception
     * @property Grid\Column|Collection failed_at
     * @property Grid\Column|Collection email
     * @property Grid\Column|Collection token
     * @property Grid\Column|Collection shop_group_id
     * @property Grid\Column|Collection price
     * @property Grid\Column|Collection r_order_id
     * @property Grid\Column|Collection qty
     * @property Grid\Column|Collection disabled
     * @property Grid\Column|Collection orderdates
     * @property Grid\Column|Collection txt_dept
     * @property Grid\Column|Collection bl_isvalid
     * @property Grid\Column|Collection int_user_id
     * @property Grid\Column|Collection int_dept_id
     * @property Grid\Column|Collection chr_tel
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
     * @property Grid\Column|Collection chr_ip
     * @property Grid\Column|Collection int_itsupport_item
     * @property Grid\Column|Collection int_itsupport_detail
     * @property Grid\Column|Collection int_important
     * @property Grid\Column|Collection int_status
     * @property Grid\Column|Collection report_date
     * @property Grid\Column|Collection chr_machine_code
     * @property Grid\Column|Collection chr_other
     * @property Grid\Column|Collection chr_pic
     * @property Grid\Column|Collection last_update_date
     * @property Grid\Column|Collection last_update_user
     * @property Grid\Column|Collection txt_comment
     * @property Grid\Column|Collection int_item_id
     * @property Grid\Column|Collection chr_prefix
     * @property Grid\Column|Collection chr_enforce_case_num
     * @property Grid\Column|Collection int_branch
     * @property Grid\Column|Collection datetime_input_date
     * @property Grid\Column|Collection chr_enforce_dept
     * @property Grid\Column|Collection chr_enforce_time
     * @property Grid\Column|Collection chr_enforce_risk_level
     * @property Grid\Column|Collection chr_enforce_risk_photo
     * @property Grid\Column|Collection chr_enforce_risk_measure
     * @property Grid\Column|Collection chr_enforce_risk_readLicense
     * @property Grid\Column|Collection chr_enforce_detail
     * @property Grid\Column|Collection chr_remarks
     * @property Grid\Column|Collection chr_file_name_1
     * @property Grid\Column|Collection chr_file_name_2
     * @property Grid\Column|Collection chr_file_name_3
     * @property Grid\Column|Collection chr_file_name_4
     * @property Grid\Column|Collection chr_old_file_name_1
     * @property Grid\Column|Collection chr_old_file_name_2
     * @property Grid\Column|Collection chr_old_file_name_3
     * @property Grid\Column|Collection chr_old_file_name_4
     * @property Grid\Column|Collection date_penalty_ticket
     * @property Grid\Column|Collection chr_penalty_no
     * @property Grid\Column|Collection decimal_penalty_amount
     * @property Grid\Column|Collection int_followed_by
     * @property Grid\Column|Collection date_updateDate
     * @property Grid\Column|Collection chr_shopStaff
     * @property Grid\Column|Collection bool_counter
     * @property Grid\Column|Collection bool_end
     * @property Grid\Column|Collection int_followdept
     * @property Grid\Column|Collection chr_followcont
     * @property Grid\Column|Collection int_follow_user
     * @property Grid\Column|Collection int_enforce_no
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
     * @property Grid\Column|Collection int_all_shop
     * @property Grid\Column|Collection chr_shop_list
     * @property Grid\Column|Collection chr_item_list
     * @property Grid\Column|Collection int_hide
     * @property Grid\Column|Collection int_main_item
     * @property Grid\Column|Collection order_date
     * @property Grid\Column|Collection int_form
     * @property Grid\Column|Collection int_qty
     * @property Grid\Column|Collection bl_email
     * @property Grid\Column|Collection int_po_no
     * @property Grid\Column|Collection sampledate
     * @property Grid\Column|Collection sample_id
     * @property Grid\Column|Collection int_page
     * @property Grid\Column|Collection int_product
     * @property Grid\Column|Collection chr_phase
     * @property Grid\Column|Collection chr_po_no
     * @property Grid\Column|Collection chr_dept
     * @property Grid\Column|Collection insert_date
     * @property Grid\Column|Collection int_qty_init
     * @property Grid\Column|Collection int_qty_received
     * @property Grid\Column|Collection received_date
     * @property Grid\Column|Collection reason
     * @property Grid\Column|Collection chr_name_long
     * @property Grid\Column|Collection int_group_id
     * @property Grid\Column|Collection int_menu_id
     * @property Grid\Column|Collection int_report_id
     * @property Grid\Column|Collection chr_time
     * @property Grid\Column|Collection chr_weekday
     * @property Grid\Column|Collection int_area_id
     * @property Grid\Column|Collection int_loc_id
     * @property Grid\Column|Collection int_repair_loc
     * @property Grid\Column|Collection int_repair_item
     * @property Grid\Column|Collection int_repair_detail
     * @property Grid\Column|Collection complete_date
     * @property Grid\Column|Collection handle_staff
     * @property Grid\Column|Collection upload_date
     * @property Grid\Column|Collection shop
     * @property Grid\Column|Collection int_price
     * @property Grid\Column|Collection int_cal
     * @property Grid\Column|Collection email_verified_at
     *
     * @method Grid\Column|Collection id(string $label = null)
     * @method Grid\Column|Collection username(string $label = null)
     * @method Grid\Column|Collection name(string $label = null)
     * @method Grid\Column|Collection roles(string $label = null)
     * @method Grid\Column|Collection permissions(string $label = null)
     * @method Grid\Column|Collection created_at(string $label = null)
     * @method Grid\Column|Collection updated_at(string $label = null)
     * @method Grid\Column|Collection avatar(string $label = null)
     * @method Grid\Column|Collection user(string $label = null)
     * @method Grid\Column|Collection method(string $label = null)
     * @method Grid\Column|Collection path(string $label = null)
     * @method Grid\Column|Collection ip(string $label = null)
     * @method Grid\Column|Collection input(string $label = null)
     * @method Grid\Column|Collection slug(string $label = null)
     * @method Grid\Column|Collection version(string $label = null)
     * @method Grid\Column|Collection alias(string $label = null)
     * @method Grid\Column|Collection authors(string $label = null)
     * @method Grid\Column|Collection enable(string $label = null)
     * @method Grid\Column|Collection imported(string $label = null)
     * @method Grid\Column|Collection config(string $label = null)
     * @method Grid\Column|Collection require(string $label = null)
     * @method Grid\Column|Collection require_dev(string $label = null)
     * @method Grid\Column|Collection int_id(string $label = null)
     * @method Grid\Column|Collection txt_login(string $label = null)
     * @method Grid\Column|Collection txt_name(string $label = null)
     * @method Grid\Column|Collection txt_password(string $label = null)
     * @method Grid\Column|Collection chr_report_name(string $label = null)
     * @method Grid\Column|Collection int_dept(string $label = null)
     * @method Grid\Column|Collection int_district(string $label = null)
     * @method Grid\Column|Collection chr_mobile(string $label = null)
     * @method Grid\Column|Collection chr_officephone(string $label = null)
     * @method Grid\Column|Collection chr_email(string $label = null)
     * @method Grid\Column|Collection chr_type(string $label = null)
     * @method Grid\Column|Collection chr_title(string $label = null)
     * @method Grid\Column|Collection chr_fax(string $label = null)
     * @method Grid\Column|Collection chr_outlet(string $label = null)
     * @method Grid\Column|Collection chr_sub(string $label = null)
     * @method Grid\Column|Collection chr_ename(string $label = null)
     * @method Grid\Column|Collection int_boss(string $label = null)
     * @method Grid\Column|Collection int_dis(string $label = null)
     * @method Grid\Column|Collection chr_sap(string $label = null)
     * @method Grid\Column|Collection int_no(string $label = null)
     * @method Grid\Column|Collection chr_visible(string $label = null)
     * @method Grid\Column|Collection int_force(string $label = null)
     * @method Grid\Column|Collection chr_pocode(string $label = null)
     * @method Grid\Column|Collection int_sort(string $label = null)
     * @method Grid\Column|Collection chr_no(string $label = null)
     * @method Grid\Column|Collection chr_name(string $label = null)
     * @method Grid\Column|Collection int_base(string $label = null)
     * @method Grid\Column|Collection int_min(string $label = null)
     * @method Grid\Column|Collection int_default_price(string $label = null)
     * @method Grid\Column|Collection chr_cuttime(string $label = null)
     * @method Grid\Column|Collection int_phase(string $label = null)
     * @method Grid\Column|Collection status(string $label = null)
     * @method Grid\Column|Collection prices(string $label = null)
     * @method Grid\Column|Collection int_group(string $label = null)
     * @method Grid\Column|Collection int_unit(string $label = null)
     * @method Grid\Column|Collection chr_sap_2(string $label = null)
     * @method Grid\Column|Collection int_unit_2(string $label = null)
     * @method Grid\Column|Collection chr_image(string $label = null)
     * @method Grid\Column|Collection txt_detail_1(string $label = null)
     * @method Grid\Column|Collection txt_detail_2(string $label = null)
     * @method Grid\Column|Collection txt_detail_3(string $label = null)
     * @method Grid\Column|Collection last_modify(string $label = null)
     * @method Grid\Column|Collection chr_canordertime(string $label = null)
     * @method Grid\Column|Collection int_cat(string $label = null)
     * @method Grid\Column|Collection txt_path(string $label = null)
     * @method Grid\Column|Collection int_user(string $label = null)
     * @method Grid\Column|Collection date_create(string $label = null)
     * @method Grid\Column|Collection date_modify(string $label = null)
     * @method Grid\Column|Collection date_delete(string $label = null)
     * @method Grid\Column|Collection date_last(string $label = null)
     * @method Grid\Column|Collection first_path(string $label = null)
     * @method Grid\Column|Collection int_num_of_day(string $label = null)
     * @method Grid\Column|Collection sort(string $label = null)
     * @method Grid\Column|Collection parent_id(string $label = null)
     * @method Grid\Column|Collection order(string $label = null)
     * @method Grid\Column|Collection icon(string $label = null)
     * @method Grid\Column|Collection uri(string $label = null)
     * @method Grid\Column|Collection user_id(string $label = null)
     * @method Grid\Column|Collection permission_id(string $label = null)
     * @method Grid\Column|Collection menu_id(string $label = null)
     * @method Grid\Column|Collection http_method(string $label = null)
     * @method Grid\Column|Collection http_path(string $label = null)
     * @method Grid\Column|Collection role_id(string $label = null)
     * @method Grid\Column|Collection password(string $label = null)
     * @method Grid\Column|Collection remember_token(string $label = null)
     * @method Grid\Column|Collection bio(string $label = null)
     * @method Grid\Column|Collection painter_id(string $label = null)
     * @method Grid\Column|Collection body(string $label = null)
     * @method Grid\Column|Collection completed_at(string $label = null)
     * @method Grid\Column|Collection connection(string $label = null)
     * @method Grid\Column|Collection queue(string $label = null)
     * @method Grid\Column|Collection payload(string $label = null)
     * @method Grid\Column|Collection exception(string $label = null)
     * @method Grid\Column|Collection failed_at(string $label = null)
     * @method Grid\Column|Collection email(string $label = null)
     * @method Grid\Column|Collection token(string $label = null)
     * @method Grid\Column|Collection shop_group_id(string $label = null)
     * @method Grid\Column|Collection price(string $label = null)
     * @method Grid\Column|Collection r_order_id(string $label = null)
     * @method Grid\Column|Collection qty(string $label = null)
     * @method Grid\Column|Collection disabled(string $label = null)
     * @method Grid\Column|Collection orderdates(string $label = null)
     * @method Grid\Column|Collection txt_dept(string $label = null)
     * @method Grid\Column|Collection bl_isvalid(string $label = null)
     * @method Grid\Column|Collection int_user_id(string $label = null)
     * @method Grid\Column|Collection int_dept_id(string $label = null)
     * @method Grid\Column|Collection chr_tel(string $label = null)
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
     * @method Grid\Column|Collection chr_ip(string $label = null)
     * @method Grid\Column|Collection int_itsupport_item(string $label = null)
     * @method Grid\Column|Collection int_itsupport_detail(string $label = null)
     * @method Grid\Column|Collection int_important(string $label = null)
     * @method Grid\Column|Collection int_status(string $label = null)
     * @method Grid\Column|Collection report_date(string $label = null)
     * @method Grid\Column|Collection chr_machine_code(string $label = null)
     * @method Grid\Column|Collection chr_other(string $label = null)
     * @method Grid\Column|Collection chr_pic(string $label = null)
     * @method Grid\Column|Collection last_update_date(string $label = null)
     * @method Grid\Column|Collection last_update_user(string $label = null)
     * @method Grid\Column|Collection txt_comment(string $label = null)
     * @method Grid\Column|Collection int_item_id(string $label = null)
     * @method Grid\Column|Collection chr_prefix(string $label = null)
     * @method Grid\Column|Collection chr_enforce_case_num(string $label = null)
     * @method Grid\Column|Collection int_branch(string $label = null)
     * @method Grid\Column|Collection datetime_input_date(string $label = null)
     * @method Grid\Column|Collection chr_enforce_dept(string $label = null)
     * @method Grid\Column|Collection chr_enforce_time(string $label = null)
     * @method Grid\Column|Collection chr_enforce_risk_level(string $label = null)
     * @method Grid\Column|Collection chr_enforce_risk_photo(string $label = null)
     * @method Grid\Column|Collection chr_enforce_risk_measure(string $label = null)
     * @method Grid\Column|Collection chr_enforce_risk_readLicense(string $label = null)
     * @method Grid\Column|Collection chr_enforce_detail(string $label = null)
     * @method Grid\Column|Collection chr_remarks(string $label = null)
     * @method Grid\Column|Collection chr_file_name_1(string $label = null)
     * @method Grid\Column|Collection chr_file_name_2(string $label = null)
     * @method Grid\Column|Collection chr_file_name_3(string $label = null)
     * @method Grid\Column|Collection chr_file_name_4(string $label = null)
     * @method Grid\Column|Collection chr_old_file_name_1(string $label = null)
     * @method Grid\Column|Collection chr_old_file_name_2(string $label = null)
     * @method Grid\Column|Collection chr_old_file_name_3(string $label = null)
     * @method Grid\Column|Collection chr_old_file_name_4(string $label = null)
     * @method Grid\Column|Collection date_penalty_ticket(string $label = null)
     * @method Grid\Column|Collection chr_penalty_no(string $label = null)
     * @method Grid\Column|Collection decimal_penalty_amount(string $label = null)
     * @method Grid\Column|Collection int_followed_by(string $label = null)
     * @method Grid\Column|Collection date_updateDate(string $label = null)
     * @method Grid\Column|Collection chr_shopStaff(string $label = null)
     * @method Grid\Column|Collection bool_counter(string $label = null)
     * @method Grid\Column|Collection bool_end(string $label = null)
     * @method Grid\Column|Collection int_followdept(string $label = null)
     * @method Grid\Column|Collection chr_followcont(string $label = null)
     * @method Grid\Column|Collection int_follow_user(string $label = null)
     * @method Grid\Column|Collection int_enforce_no(string $label = null)
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
     * @method Grid\Column|Collection int_all_shop(string $label = null)
     * @method Grid\Column|Collection chr_shop_list(string $label = null)
     * @method Grid\Column|Collection chr_item_list(string $label = null)
     * @method Grid\Column|Collection int_hide(string $label = null)
     * @method Grid\Column|Collection int_main_item(string $label = null)
     * @method Grid\Column|Collection order_date(string $label = null)
     * @method Grid\Column|Collection int_form(string $label = null)
     * @method Grid\Column|Collection int_qty(string $label = null)
     * @method Grid\Column|Collection bl_email(string $label = null)
     * @method Grid\Column|Collection int_po_no(string $label = null)
     * @method Grid\Column|Collection sampledate(string $label = null)
     * @method Grid\Column|Collection sample_id(string $label = null)
     * @method Grid\Column|Collection int_page(string $label = null)
     * @method Grid\Column|Collection int_product(string $label = null)
     * @method Grid\Column|Collection chr_phase(string $label = null)
     * @method Grid\Column|Collection chr_po_no(string $label = null)
     * @method Grid\Column|Collection chr_dept(string $label = null)
     * @method Grid\Column|Collection insert_date(string $label = null)
     * @method Grid\Column|Collection int_qty_init(string $label = null)
     * @method Grid\Column|Collection int_qty_received(string $label = null)
     * @method Grid\Column|Collection received_date(string $label = null)
     * @method Grid\Column|Collection reason(string $label = null)
     * @method Grid\Column|Collection chr_name_long(string $label = null)
     * @method Grid\Column|Collection int_group_id(string $label = null)
     * @method Grid\Column|Collection int_menu_id(string $label = null)
     * @method Grid\Column|Collection int_report_id(string $label = null)
     * @method Grid\Column|Collection chr_time(string $label = null)
     * @method Grid\Column|Collection chr_weekday(string $label = null)
     * @method Grid\Column|Collection int_area_id(string $label = null)
     * @method Grid\Column|Collection int_loc_id(string $label = null)
     * @method Grid\Column|Collection int_repair_loc(string $label = null)
     * @method Grid\Column|Collection int_repair_item(string $label = null)
     * @method Grid\Column|Collection int_repair_detail(string $label = null)
     * @method Grid\Column|Collection complete_date(string $label = null)
     * @method Grid\Column|Collection handle_staff(string $label = null)
     * @method Grid\Column|Collection upload_date(string $label = null)
     * @method Grid\Column|Collection shop(string $label = null)
     * @method Grid\Column|Collection int_price(string $label = null)
     * @method Grid\Column|Collection int_cal(string $label = null)
     * @method Grid\Column|Collection email_verified_at(string $label = null)
     */
    class Grid {}

    class MiniGrid extends Grid {}

    /**
     * @property Show\Field|Collection id
     * @property Show\Field|Collection username
     * @property Show\Field|Collection name
     * @property Show\Field|Collection roles
     * @property Show\Field|Collection permissions
     * @property Show\Field|Collection created_at
     * @property Show\Field|Collection updated_at
     * @property Show\Field|Collection avatar
     * @property Show\Field|Collection user
     * @property Show\Field|Collection method
     * @property Show\Field|Collection path
     * @property Show\Field|Collection ip
     * @property Show\Field|Collection input
     * @property Show\Field|Collection slug
     * @property Show\Field|Collection version
     * @property Show\Field|Collection alias
     * @property Show\Field|Collection authors
     * @property Show\Field|Collection enable
     * @property Show\Field|Collection imported
     * @property Show\Field|Collection config
     * @property Show\Field|Collection require
     * @property Show\Field|Collection require_dev
     * @property Show\Field|Collection int_id
     * @property Show\Field|Collection txt_login
     * @property Show\Field|Collection txt_name
     * @property Show\Field|Collection txt_password
     * @property Show\Field|Collection chr_report_name
     * @property Show\Field|Collection int_dept
     * @property Show\Field|Collection int_district
     * @property Show\Field|Collection chr_mobile
     * @property Show\Field|Collection chr_officephone
     * @property Show\Field|Collection chr_email
     * @property Show\Field|Collection chr_type
     * @property Show\Field|Collection chr_title
     * @property Show\Field|Collection chr_fax
     * @property Show\Field|Collection chr_outlet
     * @property Show\Field|Collection chr_sub
     * @property Show\Field|Collection chr_ename
     * @property Show\Field|Collection int_boss
     * @property Show\Field|Collection int_dis
     * @property Show\Field|Collection chr_sap
     * @property Show\Field|Collection int_no
     * @property Show\Field|Collection chr_visible
     * @property Show\Field|Collection int_force
     * @property Show\Field|Collection chr_pocode
     * @property Show\Field|Collection int_sort
     * @property Show\Field|Collection chr_no
     * @property Show\Field|Collection chr_name
     * @property Show\Field|Collection int_base
     * @property Show\Field|Collection int_min
     * @property Show\Field|Collection int_default_price
     * @property Show\Field|Collection chr_cuttime
     * @property Show\Field|Collection int_phase
     * @property Show\Field|Collection status
     * @property Show\Field|Collection prices
     * @property Show\Field|Collection int_group
     * @property Show\Field|Collection int_unit
     * @property Show\Field|Collection chr_sap_2
     * @property Show\Field|Collection int_unit_2
     * @property Show\Field|Collection chr_image
     * @property Show\Field|Collection txt_detail_1
     * @property Show\Field|Collection txt_detail_2
     * @property Show\Field|Collection txt_detail_3
     * @property Show\Field|Collection last_modify
     * @property Show\Field|Collection chr_canordertime
     * @property Show\Field|Collection int_cat
     * @property Show\Field|Collection txt_path
     * @property Show\Field|Collection int_user
     * @property Show\Field|Collection date_create
     * @property Show\Field|Collection date_modify
     * @property Show\Field|Collection date_delete
     * @property Show\Field|Collection date_last
     * @property Show\Field|Collection first_path
     * @property Show\Field|Collection int_num_of_day
     * @property Show\Field|Collection sort
     * @property Show\Field|Collection parent_id
     * @property Show\Field|Collection order
     * @property Show\Field|Collection icon
     * @property Show\Field|Collection uri
     * @property Show\Field|Collection user_id
     * @property Show\Field|Collection permission_id
     * @property Show\Field|Collection menu_id
     * @property Show\Field|Collection http_method
     * @property Show\Field|Collection http_path
     * @property Show\Field|Collection role_id
     * @property Show\Field|Collection password
     * @property Show\Field|Collection remember_token
     * @property Show\Field|Collection bio
     * @property Show\Field|Collection painter_id
     * @property Show\Field|Collection body
     * @property Show\Field|Collection completed_at
     * @property Show\Field|Collection connection
     * @property Show\Field|Collection queue
     * @property Show\Field|Collection payload
     * @property Show\Field|Collection exception
     * @property Show\Field|Collection failed_at
     * @property Show\Field|Collection email
     * @property Show\Field|Collection token
     * @property Show\Field|Collection shop_group_id
     * @property Show\Field|Collection price
     * @property Show\Field|Collection r_order_id
     * @property Show\Field|Collection qty
     * @property Show\Field|Collection disabled
     * @property Show\Field|Collection orderdates
     * @property Show\Field|Collection txt_dept
     * @property Show\Field|Collection bl_isvalid
     * @property Show\Field|Collection int_user_id
     * @property Show\Field|Collection int_dept_id
     * @property Show\Field|Collection chr_tel
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
     * @property Show\Field|Collection chr_ip
     * @property Show\Field|Collection int_itsupport_item
     * @property Show\Field|Collection int_itsupport_detail
     * @property Show\Field|Collection int_important
     * @property Show\Field|Collection int_status
     * @property Show\Field|Collection report_date
     * @property Show\Field|Collection chr_machine_code
     * @property Show\Field|Collection chr_other
     * @property Show\Field|Collection chr_pic
     * @property Show\Field|Collection last_update_date
     * @property Show\Field|Collection last_update_user
     * @property Show\Field|Collection txt_comment
     * @property Show\Field|Collection int_item_id
     * @property Show\Field|Collection chr_prefix
     * @property Show\Field|Collection chr_enforce_case_num
     * @property Show\Field|Collection int_branch
     * @property Show\Field|Collection datetime_input_date
     * @property Show\Field|Collection chr_enforce_dept
     * @property Show\Field|Collection chr_enforce_time
     * @property Show\Field|Collection chr_enforce_risk_level
     * @property Show\Field|Collection chr_enforce_risk_photo
     * @property Show\Field|Collection chr_enforce_risk_measure
     * @property Show\Field|Collection chr_enforce_risk_readLicense
     * @property Show\Field|Collection chr_enforce_detail
     * @property Show\Field|Collection chr_remarks
     * @property Show\Field|Collection chr_file_name_1
     * @property Show\Field|Collection chr_file_name_2
     * @property Show\Field|Collection chr_file_name_3
     * @property Show\Field|Collection chr_file_name_4
     * @property Show\Field|Collection chr_old_file_name_1
     * @property Show\Field|Collection chr_old_file_name_2
     * @property Show\Field|Collection chr_old_file_name_3
     * @property Show\Field|Collection chr_old_file_name_4
     * @property Show\Field|Collection date_penalty_ticket
     * @property Show\Field|Collection chr_penalty_no
     * @property Show\Field|Collection decimal_penalty_amount
     * @property Show\Field|Collection int_followed_by
     * @property Show\Field|Collection date_updateDate
     * @property Show\Field|Collection chr_shopStaff
     * @property Show\Field|Collection bool_counter
     * @property Show\Field|Collection bool_end
     * @property Show\Field|Collection int_followdept
     * @property Show\Field|Collection chr_followcont
     * @property Show\Field|Collection int_follow_user
     * @property Show\Field|Collection int_enforce_no
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
     * @property Show\Field|Collection int_all_shop
     * @property Show\Field|Collection chr_shop_list
     * @property Show\Field|Collection chr_item_list
     * @property Show\Field|Collection int_hide
     * @property Show\Field|Collection int_main_item
     * @property Show\Field|Collection order_date
     * @property Show\Field|Collection int_form
     * @property Show\Field|Collection int_qty
     * @property Show\Field|Collection bl_email
     * @property Show\Field|Collection int_po_no
     * @property Show\Field|Collection sampledate
     * @property Show\Field|Collection sample_id
     * @property Show\Field|Collection int_page
     * @property Show\Field|Collection int_product
     * @property Show\Field|Collection chr_phase
     * @property Show\Field|Collection chr_po_no
     * @property Show\Field|Collection chr_dept
     * @property Show\Field|Collection insert_date
     * @property Show\Field|Collection int_qty_init
     * @property Show\Field|Collection int_qty_received
     * @property Show\Field|Collection received_date
     * @property Show\Field|Collection reason
     * @property Show\Field|Collection chr_name_long
     * @property Show\Field|Collection int_group_id
     * @property Show\Field|Collection int_menu_id
     * @property Show\Field|Collection int_report_id
     * @property Show\Field|Collection chr_time
     * @property Show\Field|Collection chr_weekday
     * @property Show\Field|Collection int_area_id
     * @property Show\Field|Collection int_loc_id
     * @property Show\Field|Collection int_repair_loc
     * @property Show\Field|Collection int_repair_item
     * @property Show\Field|Collection int_repair_detail
     * @property Show\Field|Collection complete_date
     * @property Show\Field|Collection handle_staff
     * @property Show\Field|Collection upload_date
     * @property Show\Field|Collection shop
     * @property Show\Field|Collection int_price
     * @property Show\Field|Collection int_cal
     * @property Show\Field|Collection email_verified_at
     *
     * @method Show\Field|Collection id(string $label = null)
     * @method Show\Field|Collection username(string $label = null)
     * @method Show\Field|Collection name(string $label = null)
     * @method Show\Field|Collection roles(string $label = null)
     * @method Show\Field|Collection permissions(string $label = null)
     * @method Show\Field|Collection created_at(string $label = null)
     * @method Show\Field|Collection updated_at(string $label = null)
     * @method Show\Field|Collection avatar(string $label = null)
     * @method Show\Field|Collection user(string $label = null)
     * @method Show\Field|Collection method(string $label = null)
     * @method Show\Field|Collection path(string $label = null)
     * @method Show\Field|Collection ip(string $label = null)
     * @method Show\Field|Collection input(string $label = null)
     * @method Show\Field|Collection slug(string $label = null)
     * @method Show\Field|Collection version(string $label = null)
     * @method Show\Field|Collection alias(string $label = null)
     * @method Show\Field|Collection authors(string $label = null)
     * @method Show\Field|Collection enable(string $label = null)
     * @method Show\Field|Collection imported(string $label = null)
     * @method Show\Field|Collection config(string $label = null)
     * @method Show\Field|Collection require(string $label = null)
     * @method Show\Field|Collection require_dev(string $label = null)
     * @method Show\Field|Collection int_id(string $label = null)
     * @method Show\Field|Collection txt_login(string $label = null)
     * @method Show\Field|Collection txt_name(string $label = null)
     * @method Show\Field|Collection txt_password(string $label = null)
     * @method Show\Field|Collection chr_report_name(string $label = null)
     * @method Show\Field|Collection int_dept(string $label = null)
     * @method Show\Field|Collection int_district(string $label = null)
     * @method Show\Field|Collection chr_mobile(string $label = null)
     * @method Show\Field|Collection chr_officephone(string $label = null)
     * @method Show\Field|Collection chr_email(string $label = null)
     * @method Show\Field|Collection chr_type(string $label = null)
     * @method Show\Field|Collection chr_title(string $label = null)
     * @method Show\Field|Collection chr_fax(string $label = null)
     * @method Show\Field|Collection chr_outlet(string $label = null)
     * @method Show\Field|Collection chr_sub(string $label = null)
     * @method Show\Field|Collection chr_ename(string $label = null)
     * @method Show\Field|Collection int_boss(string $label = null)
     * @method Show\Field|Collection int_dis(string $label = null)
     * @method Show\Field|Collection chr_sap(string $label = null)
     * @method Show\Field|Collection int_no(string $label = null)
     * @method Show\Field|Collection chr_visible(string $label = null)
     * @method Show\Field|Collection int_force(string $label = null)
     * @method Show\Field|Collection chr_pocode(string $label = null)
     * @method Show\Field|Collection int_sort(string $label = null)
     * @method Show\Field|Collection chr_no(string $label = null)
     * @method Show\Field|Collection chr_name(string $label = null)
     * @method Show\Field|Collection int_base(string $label = null)
     * @method Show\Field|Collection int_min(string $label = null)
     * @method Show\Field|Collection int_default_price(string $label = null)
     * @method Show\Field|Collection chr_cuttime(string $label = null)
     * @method Show\Field|Collection int_phase(string $label = null)
     * @method Show\Field|Collection status(string $label = null)
     * @method Show\Field|Collection prices(string $label = null)
     * @method Show\Field|Collection int_group(string $label = null)
     * @method Show\Field|Collection int_unit(string $label = null)
     * @method Show\Field|Collection chr_sap_2(string $label = null)
     * @method Show\Field|Collection int_unit_2(string $label = null)
     * @method Show\Field|Collection chr_image(string $label = null)
     * @method Show\Field|Collection txt_detail_1(string $label = null)
     * @method Show\Field|Collection txt_detail_2(string $label = null)
     * @method Show\Field|Collection txt_detail_3(string $label = null)
     * @method Show\Field|Collection last_modify(string $label = null)
     * @method Show\Field|Collection chr_canordertime(string $label = null)
     * @method Show\Field|Collection int_cat(string $label = null)
     * @method Show\Field|Collection txt_path(string $label = null)
     * @method Show\Field|Collection int_user(string $label = null)
     * @method Show\Field|Collection date_create(string $label = null)
     * @method Show\Field|Collection date_modify(string $label = null)
     * @method Show\Field|Collection date_delete(string $label = null)
     * @method Show\Field|Collection date_last(string $label = null)
     * @method Show\Field|Collection first_path(string $label = null)
     * @method Show\Field|Collection int_num_of_day(string $label = null)
     * @method Show\Field|Collection sort(string $label = null)
     * @method Show\Field|Collection parent_id(string $label = null)
     * @method Show\Field|Collection order(string $label = null)
     * @method Show\Field|Collection icon(string $label = null)
     * @method Show\Field|Collection uri(string $label = null)
     * @method Show\Field|Collection user_id(string $label = null)
     * @method Show\Field|Collection permission_id(string $label = null)
     * @method Show\Field|Collection menu_id(string $label = null)
     * @method Show\Field|Collection http_method(string $label = null)
     * @method Show\Field|Collection http_path(string $label = null)
     * @method Show\Field|Collection role_id(string $label = null)
     * @method Show\Field|Collection password(string $label = null)
     * @method Show\Field|Collection remember_token(string $label = null)
     * @method Show\Field|Collection bio(string $label = null)
     * @method Show\Field|Collection painter_id(string $label = null)
     * @method Show\Field|Collection body(string $label = null)
     * @method Show\Field|Collection completed_at(string $label = null)
     * @method Show\Field|Collection connection(string $label = null)
     * @method Show\Field|Collection queue(string $label = null)
     * @method Show\Field|Collection payload(string $label = null)
     * @method Show\Field|Collection exception(string $label = null)
     * @method Show\Field|Collection failed_at(string $label = null)
     * @method Show\Field|Collection email(string $label = null)
     * @method Show\Field|Collection token(string $label = null)
     * @method Show\Field|Collection shop_group_id(string $label = null)
     * @method Show\Field|Collection price(string $label = null)
     * @method Show\Field|Collection r_order_id(string $label = null)
     * @method Show\Field|Collection qty(string $label = null)
     * @method Show\Field|Collection disabled(string $label = null)
     * @method Show\Field|Collection orderdates(string $label = null)
     * @method Show\Field|Collection txt_dept(string $label = null)
     * @method Show\Field|Collection bl_isvalid(string $label = null)
     * @method Show\Field|Collection int_user_id(string $label = null)
     * @method Show\Field|Collection int_dept_id(string $label = null)
     * @method Show\Field|Collection chr_tel(string $label = null)
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
     * @method Show\Field|Collection chr_ip(string $label = null)
     * @method Show\Field|Collection int_itsupport_item(string $label = null)
     * @method Show\Field|Collection int_itsupport_detail(string $label = null)
     * @method Show\Field|Collection int_important(string $label = null)
     * @method Show\Field|Collection int_status(string $label = null)
     * @method Show\Field|Collection report_date(string $label = null)
     * @method Show\Field|Collection chr_machine_code(string $label = null)
     * @method Show\Field|Collection chr_other(string $label = null)
     * @method Show\Field|Collection chr_pic(string $label = null)
     * @method Show\Field|Collection last_update_date(string $label = null)
     * @method Show\Field|Collection last_update_user(string $label = null)
     * @method Show\Field|Collection txt_comment(string $label = null)
     * @method Show\Field|Collection int_item_id(string $label = null)
     * @method Show\Field|Collection chr_prefix(string $label = null)
     * @method Show\Field|Collection chr_enforce_case_num(string $label = null)
     * @method Show\Field|Collection int_branch(string $label = null)
     * @method Show\Field|Collection datetime_input_date(string $label = null)
     * @method Show\Field|Collection chr_enforce_dept(string $label = null)
     * @method Show\Field|Collection chr_enforce_time(string $label = null)
     * @method Show\Field|Collection chr_enforce_risk_level(string $label = null)
     * @method Show\Field|Collection chr_enforce_risk_photo(string $label = null)
     * @method Show\Field|Collection chr_enforce_risk_measure(string $label = null)
     * @method Show\Field|Collection chr_enforce_risk_readLicense(string $label = null)
     * @method Show\Field|Collection chr_enforce_detail(string $label = null)
     * @method Show\Field|Collection chr_remarks(string $label = null)
     * @method Show\Field|Collection chr_file_name_1(string $label = null)
     * @method Show\Field|Collection chr_file_name_2(string $label = null)
     * @method Show\Field|Collection chr_file_name_3(string $label = null)
     * @method Show\Field|Collection chr_file_name_4(string $label = null)
     * @method Show\Field|Collection chr_old_file_name_1(string $label = null)
     * @method Show\Field|Collection chr_old_file_name_2(string $label = null)
     * @method Show\Field|Collection chr_old_file_name_3(string $label = null)
     * @method Show\Field|Collection chr_old_file_name_4(string $label = null)
     * @method Show\Field|Collection date_penalty_ticket(string $label = null)
     * @method Show\Field|Collection chr_penalty_no(string $label = null)
     * @method Show\Field|Collection decimal_penalty_amount(string $label = null)
     * @method Show\Field|Collection int_followed_by(string $label = null)
     * @method Show\Field|Collection date_updateDate(string $label = null)
     * @method Show\Field|Collection chr_shopStaff(string $label = null)
     * @method Show\Field|Collection bool_counter(string $label = null)
     * @method Show\Field|Collection bool_end(string $label = null)
     * @method Show\Field|Collection int_followdept(string $label = null)
     * @method Show\Field|Collection chr_followcont(string $label = null)
     * @method Show\Field|Collection int_follow_user(string $label = null)
     * @method Show\Field|Collection int_enforce_no(string $label = null)
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
     * @method Show\Field|Collection int_all_shop(string $label = null)
     * @method Show\Field|Collection chr_shop_list(string $label = null)
     * @method Show\Field|Collection chr_item_list(string $label = null)
     * @method Show\Field|Collection int_hide(string $label = null)
     * @method Show\Field|Collection int_main_item(string $label = null)
     * @method Show\Field|Collection order_date(string $label = null)
     * @method Show\Field|Collection int_form(string $label = null)
     * @method Show\Field|Collection int_qty(string $label = null)
     * @method Show\Field|Collection bl_email(string $label = null)
     * @method Show\Field|Collection int_po_no(string $label = null)
     * @method Show\Field|Collection sampledate(string $label = null)
     * @method Show\Field|Collection sample_id(string $label = null)
     * @method Show\Field|Collection int_page(string $label = null)
     * @method Show\Field|Collection int_product(string $label = null)
     * @method Show\Field|Collection chr_phase(string $label = null)
     * @method Show\Field|Collection chr_po_no(string $label = null)
     * @method Show\Field|Collection chr_dept(string $label = null)
     * @method Show\Field|Collection insert_date(string $label = null)
     * @method Show\Field|Collection int_qty_init(string $label = null)
     * @method Show\Field|Collection int_qty_received(string $label = null)
     * @method Show\Field|Collection received_date(string $label = null)
     * @method Show\Field|Collection reason(string $label = null)
     * @method Show\Field|Collection chr_name_long(string $label = null)
     * @method Show\Field|Collection int_group_id(string $label = null)
     * @method Show\Field|Collection int_menu_id(string $label = null)
     * @method Show\Field|Collection int_report_id(string $label = null)
     * @method Show\Field|Collection chr_time(string $label = null)
     * @method Show\Field|Collection chr_weekday(string $label = null)
     * @method Show\Field|Collection int_area_id(string $label = null)
     * @method Show\Field|Collection int_loc_id(string $label = null)
     * @method Show\Field|Collection int_repair_loc(string $label = null)
     * @method Show\Field|Collection int_repair_item(string $label = null)
     * @method Show\Field|Collection int_repair_detail(string $label = null)
     * @method Show\Field|Collection complete_date(string $label = null)
     * @method Show\Field|Collection handle_staff(string $label = null)
     * @method Show\Field|Collection upload_date(string $label = null)
     * @method Show\Field|Collection shop(string $label = null)
     * @method Show\Field|Collection int_price(string $label = null)
     * @method Show\Field|Collection int_cal(string $label = null)
     * @method Show\Field|Collection email_verified_at(string $label = null)
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
