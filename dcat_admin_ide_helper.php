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
     * @property Grid\Column|Collection cat_name
     * @property Grid\Column|Collection sort
     * @property Grid\Column|Collection status
     * @property Grid\Column|Collection start_date
     * @property Grid\Column|Collection end_date
     * @property Grid\Column|Collection id
     * @property Grid\Column|Collection product_no
     * @property Grid\Column|Collection product_name
     * @property Grid\Column|Collection group_name
     * @property Grid\Column|Collection last_modify
     * @property Grid\Column|Collection cat_id
     * @property Grid\Column|Collection short_name
     * @property Grid\Column|Collection report_name
     * @property Grid\Column|Collection num_of_day
     * @property Grid\Column|Collection int_hide
     * @property Grid\Column|Collection disabled
     * @property Grid\Column|Collection time
     * @property Grid\Column|Collection created_at
     * @property Grid\Column|Collection updated_at
     * @property Grid\Column|Collection log
     * @property Grid\Column|Collection txt_name
     * @property Grid\Column|Collection roles
     * @property Grid\Column|Collection email
     * @property Grid\Column|Collection guard_name
     * @property Grid\Column|Collection permissions
     * @property Grid\Column|Collection users
     * @property Grid\Column|Collection price
     * @property Grid\Column|Collection type
     * @property Grid\Column|Collection detail
     * @property Grid\Column|Collection is_enabled
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
     * @property Grid\Column|Collection value
     * @property Grid\Column|Collection username
     * @property Grid\Column|Collection password
     * @property Grid\Column|Collection avatar
     * @property Grid\Column|Collection remember_token
     * @property Grid\Column|Collection plan_no
     * @property Grid\Column|Collection max_claim_money
     * @property Grid\Column|Collection rate
     * @property Grid\Column|Collection type_name
     * @property Grid\Column|Collection times_per_day
     * @property Grid\Column|Collection times_per_year
     * @property Grid\Column|Collection employee_id
     * @property Grid\Column|Collection claim_level_id
     * @property Grid\Column|Collection approver_id
     * @property Grid\Column|Collection illness_id
     * @property Grid\Column|Collection claim_date
     * @property Grid\Column|Collection file_path
     * @property Grid\Column|Collection shop_id
     * @property Grid\Column|Collection deli_date
     * @property Grid\Column|Collection po
     * @property Grid\Column|Collection code
     * @property Grid\Column|Collection claim_level
     * @property Grid\Column|Collection is_worked
     * @property Grid\Column|Collection leave_date
     * @property Grid\Column|Collection connection
     * @property Grid\Column|Collection queue
     * @property Grid\Column|Collection payload
     * @property Grid\Column|Collection exception
     * @property Grid\Column|Collection failed_at
     * @property Grid\Column|Collection cat_ids
     * @property Grid\Column|Collection user_ids
     * @property Grid\Column|Collection forbidden_date
     * @property Grid\Column|Collection form_name
     * @property Grid\Column|Collection admin_role_id
     * @property Grid\Column|Collection created_date
     * @property Grid\Column|Collection modify_date
     * @property Grid\Column|Collection deleted_date
     * @property Grid\Column|Collection form_no
     * @property Grid\Column|Collection is_sample
     * @property Grid\Column|Collection sample_path
     * @property Grid\Column|Collection first_path
     * @property Grid\Column|Collection is_multi_print
     * @property Grid\Column|Collection group_id
     * @property Grid\Column|Collection model_type
     * @property Grid\Column|Collection model_id
     * @property Grid\Column|Collection front_group_id
     * @property Grid\Column|Collection group
     * @property Grid\Column|Collection item_id
     * @property Grid\Column|Collection it_support_no
     * @property Grid\Column|Collection itsupport_item_id
     * @property Grid\Column|Collection itsupport_detail_id
     * @property Grid\Column|Collection importance
     * @property Grid\Column|Collection machine_code
     * @property Grid\Column|Collection other
     * @property Grid\Column|Collection last_update_user
     * @property Grid\Column|Collection comment
     * @property Grid\Column|Collection complete_date
     * @property Grid\Column|Collection handle_staff
     * @property Grid\Column|Collection finished_start_time
     * @property Grid\Column|Collection finished_end_time
     * @property Grid\Column|Collection fee
     * @property Grid\Column|Collection contact_person
     * @property Grid\Column|Collection library_type
     * @property Grid\Column|Collection file_name
     * @property Grid\Column|Collection link_path
     * @property Grid\Column|Collection link_name
     * @property Grid\Column|Collection view_type
     * @property Grid\Column|Collection deleted_at
     * @property Grid\Column|Collection notice_id
     * @property Grid\Column|Collection notice_name
     * @property Grid\Column|Collection notice_no
     * @property Grid\Column|Collection expired_date
     * @property Grid\Column|Collection is_directory
     * @property Grid\Column|Collection is_test
     * @property Grid\Column|Collection token
     * @property Grid\Column|Collection product_id
     * @property Grid\Column|Collection shop_group_id
     * @property Grid\Column|Collection cuttime
     * @property Grid\Column|Collection phase
     * @property Grid\Column|Collection canordertime
     * @property Grid\Column|Collection base
     * @property Grid\Column|Collection min
     * @property Grid\Column|Collection check_id
     * @property Grid\Column|Collection weekday
     * @property Grid\Column|Collection r_order_id
     * @property Grid\Column|Collection qty
     * @property Grid\Column|Collection orderdates
     * @property Grid\Column|Collection order_no
     * @property Grid\Column|Collection repair_project_no
     * @property Grid\Column|Collection repair_location_id
     * @property Grid\Column|Collection repair_item_id
     * @property Grid\Column|Collection repair_detail_id
     * @property Grid\Column|Collection repair_order_id
     * @property Grid\Column|Collection shop_name
     * @property Grid\Column|Collection tel
     * @property Grid\Column|Collection fax
     * @property Grid\Column|Collection address
     * @property Grid\Column|Collection eng_address
     * @property Grid\Column|Collection int_area
     * @property Grid\Column|Collection oper_time
     * @property Grid\Column|Collection special_date
     * @property Grid\Column|Collection month
     * @property Grid\Column|Collection unit_id
     * @property Grid\Column|Collection product_name_short
     * @property Grid\Column|Collection supplier_id
     * @property Grid\Column|Collection base_unit_id
     * @property Grid\Column|Collection base_qty
     * @property Grid\Column|Collection base_price
     * @property Grid\Column|Collection default_price
     * @property Grid\Column|Collection weight
     * @property Grid\Column|Collection weight_unit
     * @property Grid\Column|Collection item_list
     * @property Grid\Column|Collection int_dept
     * @property Grid\Column|Collection address_id
     * @property Grid\Column|Collection chr_mobile
     * @property Grid\Column|Collection chr_officephone
     * @property Grid\Column|Collection chr_title
     * @property Grid\Column|Collection chr_fax
     * @property Grid\Column|Collection chr_outlet
     * @property Grid\Column|Collection chr_sub
     * @property Grid\Column|Collection chr_ename
     * @property Grid\Column|Collection int_boss
     * @property Grid\Column|Collection login_disabled
     * @property Grid\Column|Collection chr_sap
     * @property Grid\Column|Collection int_no
     * @property Grid\Column|Collection chr_visible
     * @property Grid\Column|Collection int_force
     * @property Grid\Column|Collection chr_pocode
     * @property Grid\Column|Collection email_verified_at
     * @property Grid\Column|Collection rb_user_id
     * @property Grid\Column|Collection company_chinese_name
     * @property Grid\Column|Collection company_english_name
     * @property Grid\Column|Collection pocode
     * @property Grid\Column|Collection operate_user_id
     * @property Grid\Column|Collection cart_item_id
     * @property Grid\Column|Collection order_date
     * @property Grid\Column|Collection chr_phase
     * @property Grid\Column|Collection po_no
     * @property Grid\Column|Collection dept
     * @property Grid\Column|Collection insert_date
     * @property Grid\Column|Collection int_qty_init
     * @property Grid\Column|Collection qty_received
     * @property Grid\Column|Collection received_date
     * @property Grid\Column|Collection reason
     * @property Grid\Column|Collection order_price
     * @property Grid\Column|Collection int_page
     * @property Grid\Column|Collection int_all_shop
     * @property Grid\Column|Collection shop_list
     * @property Grid\Column|Collection int_main_item
     * @property Grid\Column|Collection cut_time
     * @property Grid\Column|Collection sampledate
     * @property Grid\Column|Collection sample_id
     * @property Grid\Column|Collection chr_sap_2
     * @property Grid\Column|Collection int_unit_2
     * @property Grid\Column|Collection image
     * @property Grid\Column|Collection txt_detail_1
     * @property Grid\Column|Collection txt_detail_2
     * @property Grid\Column|Collection txt_detail_3
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
     * @method Grid\Column|Collection cat_name(string $label = null)
     * @method Grid\Column|Collection sort(string $label = null)
     * @method Grid\Column|Collection status(string $label = null)
     * @method Grid\Column|Collection start_date(string $label = null)
     * @method Grid\Column|Collection end_date(string $label = null)
     * @method Grid\Column|Collection id(string $label = null)
     * @method Grid\Column|Collection product_no(string $label = null)
     * @method Grid\Column|Collection product_name(string $label = null)
     * @method Grid\Column|Collection group_name(string $label = null)
     * @method Grid\Column|Collection last_modify(string $label = null)
     * @method Grid\Column|Collection cat_id(string $label = null)
     * @method Grid\Column|Collection short_name(string $label = null)
     * @method Grid\Column|Collection report_name(string $label = null)
     * @method Grid\Column|Collection num_of_day(string $label = null)
     * @method Grid\Column|Collection int_hide(string $label = null)
     * @method Grid\Column|Collection disabled(string $label = null)
     * @method Grid\Column|Collection time(string $label = null)
     * @method Grid\Column|Collection created_at(string $label = null)
     * @method Grid\Column|Collection updated_at(string $label = null)
     * @method Grid\Column|Collection log(string $label = null)
     * @method Grid\Column|Collection txt_name(string $label = null)
     * @method Grid\Column|Collection roles(string $label = null)
     * @method Grid\Column|Collection email(string $label = null)
     * @method Grid\Column|Collection guard_name(string $label = null)
     * @method Grid\Column|Collection permissions(string $label = null)
     * @method Grid\Column|Collection users(string $label = null)
     * @method Grid\Column|Collection price(string $label = null)
     * @method Grid\Column|Collection type(string $label = null)
     * @method Grid\Column|Collection detail(string $label = null)
     * @method Grid\Column|Collection is_enabled(string $label = null)
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
     * @method Grid\Column|Collection value(string $label = null)
     * @method Grid\Column|Collection username(string $label = null)
     * @method Grid\Column|Collection password(string $label = null)
     * @method Grid\Column|Collection avatar(string $label = null)
     * @method Grid\Column|Collection remember_token(string $label = null)
     * @method Grid\Column|Collection plan_no(string $label = null)
     * @method Grid\Column|Collection max_claim_money(string $label = null)
     * @method Grid\Column|Collection rate(string $label = null)
     * @method Grid\Column|Collection type_name(string $label = null)
     * @method Grid\Column|Collection times_per_day(string $label = null)
     * @method Grid\Column|Collection times_per_year(string $label = null)
     * @method Grid\Column|Collection employee_id(string $label = null)
     * @method Grid\Column|Collection claim_level_id(string $label = null)
     * @method Grid\Column|Collection approver_id(string $label = null)
     * @method Grid\Column|Collection illness_id(string $label = null)
     * @method Grid\Column|Collection claim_date(string $label = null)
     * @method Grid\Column|Collection file_path(string $label = null)
     * @method Grid\Column|Collection shop_id(string $label = null)
     * @method Grid\Column|Collection deli_date(string $label = null)
     * @method Grid\Column|Collection po(string $label = null)
     * @method Grid\Column|Collection code(string $label = null)
     * @method Grid\Column|Collection claim_level(string $label = null)
     * @method Grid\Column|Collection is_worked(string $label = null)
     * @method Grid\Column|Collection leave_date(string $label = null)
     * @method Grid\Column|Collection connection(string $label = null)
     * @method Grid\Column|Collection queue(string $label = null)
     * @method Grid\Column|Collection payload(string $label = null)
     * @method Grid\Column|Collection exception(string $label = null)
     * @method Grid\Column|Collection failed_at(string $label = null)
     * @method Grid\Column|Collection cat_ids(string $label = null)
     * @method Grid\Column|Collection user_ids(string $label = null)
     * @method Grid\Column|Collection forbidden_date(string $label = null)
     * @method Grid\Column|Collection form_name(string $label = null)
     * @method Grid\Column|Collection admin_role_id(string $label = null)
     * @method Grid\Column|Collection created_date(string $label = null)
     * @method Grid\Column|Collection modify_date(string $label = null)
     * @method Grid\Column|Collection deleted_date(string $label = null)
     * @method Grid\Column|Collection form_no(string $label = null)
     * @method Grid\Column|Collection is_sample(string $label = null)
     * @method Grid\Column|Collection sample_path(string $label = null)
     * @method Grid\Column|Collection first_path(string $label = null)
     * @method Grid\Column|Collection is_multi_print(string $label = null)
     * @method Grid\Column|Collection group_id(string $label = null)
     * @method Grid\Column|Collection model_type(string $label = null)
     * @method Grid\Column|Collection model_id(string $label = null)
     * @method Grid\Column|Collection front_group_id(string $label = null)
     * @method Grid\Column|Collection group(string $label = null)
     * @method Grid\Column|Collection item_id(string $label = null)
     * @method Grid\Column|Collection it_support_no(string $label = null)
     * @method Grid\Column|Collection itsupport_item_id(string $label = null)
     * @method Grid\Column|Collection itsupport_detail_id(string $label = null)
     * @method Grid\Column|Collection importance(string $label = null)
     * @method Grid\Column|Collection machine_code(string $label = null)
     * @method Grid\Column|Collection other(string $label = null)
     * @method Grid\Column|Collection last_update_user(string $label = null)
     * @method Grid\Column|Collection comment(string $label = null)
     * @method Grid\Column|Collection complete_date(string $label = null)
     * @method Grid\Column|Collection handle_staff(string $label = null)
     * @method Grid\Column|Collection finished_start_time(string $label = null)
     * @method Grid\Column|Collection finished_end_time(string $label = null)
     * @method Grid\Column|Collection fee(string $label = null)
     * @method Grid\Column|Collection contact_person(string $label = null)
     * @method Grid\Column|Collection library_type(string $label = null)
     * @method Grid\Column|Collection file_name(string $label = null)
     * @method Grid\Column|Collection link_path(string $label = null)
     * @method Grid\Column|Collection link_name(string $label = null)
     * @method Grid\Column|Collection view_type(string $label = null)
     * @method Grid\Column|Collection deleted_at(string $label = null)
     * @method Grid\Column|Collection notice_id(string $label = null)
     * @method Grid\Column|Collection notice_name(string $label = null)
     * @method Grid\Column|Collection notice_no(string $label = null)
     * @method Grid\Column|Collection expired_date(string $label = null)
     * @method Grid\Column|Collection is_directory(string $label = null)
     * @method Grid\Column|Collection is_test(string $label = null)
     * @method Grid\Column|Collection token(string $label = null)
     * @method Grid\Column|Collection product_id(string $label = null)
     * @method Grid\Column|Collection shop_group_id(string $label = null)
     * @method Grid\Column|Collection cuttime(string $label = null)
     * @method Grid\Column|Collection phase(string $label = null)
     * @method Grid\Column|Collection canordertime(string $label = null)
     * @method Grid\Column|Collection base(string $label = null)
     * @method Grid\Column|Collection min(string $label = null)
     * @method Grid\Column|Collection check_id(string $label = null)
     * @method Grid\Column|Collection weekday(string $label = null)
     * @method Grid\Column|Collection r_order_id(string $label = null)
     * @method Grid\Column|Collection qty(string $label = null)
     * @method Grid\Column|Collection orderdates(string $label = null)
     * @method Grid\Column|Collection order_no(string $label = null)
     * @method Grid\Column|Collection repair_project_no(string $label = null)
     * @method Grid\Column|Collection repair_location_id(string $label = null)
     * @method Grid\Column|Collection repair_item_id(string $label = null)
     * @method Grid\Column|Collection repair_detail_id(string $label = null)
     * @method Grid\Column|Collection repair_order_id(string $label = null)
     * @method Grid\Column|Collection shop_name(string $label = null)
     * @method Grid\Column|Collection tel(string $label = null)
     * @method Grid\Column|Collection fax(string $label = null)
     * @method Grid\Column|Collection address(string $label = null)
     * @method Grid\Column|Collection eng_address(string $label = null)
     * @method Grid\Column|Collection int_area(string $label = null)
     * @method Grid\Column|Collection oper_time(string $label = null)
     * @method Grid\Column|Collection special_date(string $label = null)
     * @method Grid\Column|Collection month(string $label = null)
     * @method Grid\Column|Collection unit_id(string $label = null)
     * @method Grid\Column|Collection product_name_short(string $label = null)
     * @method Grid\Column|Collection supplier_id(string $label = null)
     * @method Grid\Column|Collection base_unit_id(string $label = null)
     * @method Grid\Column|Collection base_qty(string $label = null)
     * @method Grid\Column|Collection base_price(string $label = null)
     * @method Grid\Column|Collection default_price(string $label = null)
     * @method Grid\Column|Collection weight(string $label = null)
     * @method Grid\Column|Collection weight_unit(string $label = null)
     * @method Grid\Column|Collection item_list(string $label = null)
     * @method Grid\Column|Collection int_dept(string $label = null)
     * @method Grid\Column|Collection address_id(string $label = null)
     * @method Grid\Column|Collection chr_mobile(string $label = null)
     * @method Grid\Column|Collection chr_officephone(string $label = null)
     * @method Grid\Column|Collection chr_title(string $label = null)
     * @method Grid\Column|Collection chr_fax(string $label = null)
     * @method Grid\Column|Collection chr_outlet(string $label = null)
     * @method Grid\Column|Collection chr_sub(string $label = null)
     * @method Grid\Column|Collection chr_ename(string $label = null)
     * @method Grid\Column|Collection int_boss(string $label = null)
     * @method Grid\Column|Collection login_disabled(string $label = null)
     * @method Grid\Column|Collection chr_sap(string $label = null)
     * @method Grid\Column|Collection int_no(string $label = null)
     * @method Grid\Column|Collection chr_visible(string $label = null)
     * @method Grid\Column|Collection int_force(string $label = null)
     * @method Grid\Column|Collection chr_pocode(string $label = null)
     * @method Grid\Column|Collection email_verified_at(string $label = null)
     * @method Grid\Column|Collection rb_user_id(string $label = null)
     * @method Grid\Column|Collection company_chinese_name(string $label = null)
     * @method Grid\Column|Collection company_english_name(string $label = null)
     * @method Grid\Column|Collection pocode(string $label = null)
     * @method Grid\Column|Collection operate_user_id(string $label = null)
     * @method Grid\Column|Collection cart_item_id(string $label = null)
     * @method Grid\Column|Collection order_date(string $label = null)
     * @method Grid\Column|Collection chr_phase(string $label = null)
     * @method Grid\Column|Collection po_no(string $label = null)
     * @method Grid\Column|Collection dept(string $label = null)
     * @method Grid\Column|Collection insert_date(string $label = null)
     * @method Grid\Column|Collection int_qty_init(string $label = null)
     * @method Grid\Column|Collection qty_received(string $label = null)
     * @method Grid\Column|Collection received_date(string $label = null)
     * @method Grid\Column|Collection reason(string $label = null)
     * @method Grid\Column|Collection order_price(string $label = null)
     * @method Grid\Column|Collection int_page(string $label = null)
     * @method Grid\Column|Collection int_all_shop(string $label = null)
     * @method Grid\Column|Collection shop_list(string $label = null)
     * @method Grid\Column|Collection int_main_item(string $label = null)
     * @method Grid\Column|Collection cut_time(string $label = null)
     * @method Grid\Column|Collection sampledate(string $label = null)
     * @method Grid\Column|Collection sample_id(string $label = null)
     * @method Grid\Column|Collection chr_sap_2(string $label = null)
     * @method Grid\Column|Collection int_unit_2(string $label = null)
     * @method Grid\Column|Collection image(string $label = null)
     * @method Grid\Column|Collection txt_detail_1(string $label = null)
     * @method Grid\Column|Collection txt_detail_2(string $label = null)
     * @method Grid\Column|Collection txt_detail_3(string $label = null)
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
     * @property Show\Field|Collection cat_name
     * @property Show\Field|Collection sort
     * @property Show\Field|Collection status
     * @property Show\Field|Collection start_date
     * @property Show\Field|Collection end_date
     * @property Show\Field|Collection id
     * @property Show\Field|Collection product_no
     * @property Show\Field|Collection product_name
     * @property Show\Field|Collection group_name
     * @property Show\Field|Collection last_modify
     * @property Show\Field|Collection cat_id
     * @property Show\Field|Collection short_name
     * @property Show\Field|Collection report_name
     * @property Show\Field|Collection num_of_day
     * @property Show\Field|Collection int_hide
     * @property Show\Field|Collection disabled
     * @property Show\Field|Collection time
     * @property Show\Field|Collection created_at
     * @property Show\Field|Collection updated_at
     * @property Show\Field|Collection log
     * @property Show\Field|Collection txt_name
     * @property Show\Field|Collection roles
     * @property Show\Field|Collection email
     * @property Show\Field|Collection guard_name
     * @property Show\Field|Collection permissions
     * @property Show\Field|Collection users
     * @property Show\Field|Collection price
     * @property Show\Field|Collection type
     * @property Show\Field|Collection detail
     * @property Show\Field|Collection is_enabled
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
     * @property Show\Field|Collection value
     * @property Show\Field|Collection username
     * @property Show\Field|Collection password
     * @property Show\Field|Collection avatar
     * @property Show\Field|Collection remember_token
     * @property Show\Field|Collection plan_no
     * @property Show\Field|Collection max_claim_money
     * @property Show\Field|Collection rate
     * @property Show\Field|Collection type_name
     * @property Show\Field|Collection times_per_day
     * @property Show\Field|Collection times_per_year
     * @property Show\Field|Collection employee_id
     * @property Show\Field|Collection claim_level_id
     * @property Show\Field|Collection approver_id
     * @property Show\Field|Collection illness_id
     * @property Show\Field|Collection claim_date
     * @property Show\Field|Collection file_path
     * @property Show\Field|Collection shop_id
     * @property Show\Field|Collection deli_date
     * @property Show\Field|Collection po
     * @property Show\Field|Collection code
     * @property Show\Field|Collection claim_level
     * @property Show\Field|Collection is_worked
     * @property Show\Field|Collection leave_date
     * @property Show\Field|Collection connection
     * @property Show\Field|Collection queue
     * @property Show\Field|Collection payload
     * @property Show\Field|Collection exception
     * @property Show\Field|Collection failed_at
     * @property Show\Field|Collection cat_ids
     * @property Show\Field|Collection user_ids
     * @property Show\Field|Collection forbidden_date
     * @property Show\Field|Collection form_name
     * @property Show\Field|Collection admin_role_id
     * @property Show\Field|Collection created_date
     * @property Show\Field|Collection modify_date
     * @property Show\Field|Collection deleted_date
     * @property Show\Field|Collection form_no
     * @property Show\Field|Collection is_sample
     * @property Show\Field|Collection sample_path
     * @property Show\Field|Collection first_path
     * @property Show\Field|Collection is_multi_print
     * @property Show\Field|Collection group_id
     * @property Show\Field|Collection model_type
     * @property Show\Field|Collection model_id
     * @property Show\Field|Collection front_group_id
     * @property Show\Field|Collection group
     * @property Show\Field|Collection item_id
     * @property Show\Field|Collection it_support_no
     * @property Show\Field|Collection itsupport_item_id
     * @property Show\Field|Collection itsupport_detail_id
     * @property Show\Field|Collection importance
     * @property Show\Field|Collection machine_code
     * @property Show\Field|Collection other
     * @property Show\Field|Collection last_update_user
     * @property Show\Field|Collection comment
     * @property Show\Field|Collection complete_date
     * @property Show\Field|Collection handle_staff
     * @property Show\Field|Collection finished_start_time
     * @property Show\Field|Collection finished_end_time
     * @property Show\Field|Collection fee
     * @property Show\Field|Collection contact_person
     * @property Show\Field|Collection library_type
     * @property Show\Field|Collection file_name
     * @property Show\Field|Collection link_path
     * @property Show\Field|Collection link_name
     * @property Show\Field|Collection view_type
     * @property Show\Field|Collection deleted_at
     * @property Show\Field|Collection notice_id
     * @property Show\Field|Collection notice_name
     * @property Show\Field|Collection notice_no
     * @property Show\Field|Collection expired_date
     * @property Show\Field|Collection is_directory
     * @property Show\Field|Collection is_test
     * @property Show\Field|Collection token
     * @property Show\Field|Collection product_id
     * @property Show\Field|Collection shop_group_id
     * @property Show\Field|Collection cuttime
     * @property Show\Field|Collection phase
     * @property Show\Field|Collection canordertime
     * @property Show\Field|Collection base
     * @property Show\Field|Collection min
     * @property Show\Field|Collection check_id
     * @property Show\Field|Collection weekday
     * @property Show\Field|Collection r_order_id
     * @property Show\Field|Collection qty
     * @property Show\Field|Collection orderdates
     * @property Show\Field|Collection order_no
     * @property Show\Field|Collection repair_project_no
     * @property Show\Field|Collection repair_location_id
     * @property Show\Field|Collection repair_item_id
     * @property Show\Field|Collection repair_detail_id
     * @property Show\Field|Collection repair_order_id
     * @property Show\Field|Collection shop_name
     * @property Show\Field|Collection tel
     * @property Show\Field|Collection fax
     * @property Show\Field|Collection address
     * @property Show\Field|Collection eng_address
     * @property Show\Field|Collection int_area
     * @property Show\Field|Collection oper_time
     * @property Show\Field|Collection special_date
     * @property Show\Field|Collection month
     * @property Show\Field|Collection unit_id
     * @property Show\Field|Collection product_name_short
     * @property Show\Field|Collection supplier_id
     * @property Show\Field|Collection base_unit_id
     * @property Show\Field|Collection base_qty
     * @property Show\Field|Collection base_price
     * @property Show\Field|Collection default_price
     * @property Show\Field|Collection weight
     * @property Show\Field|Collection weight_unit
     * @property Show\Field|Collection item_list
     * @property Show\Field|Collection int_dept
     * @property Show\Field|Collection address_id
     * @property Show\Field|Collection chr_mobile
     * @property Show\Field|Collection chr_officephone
     * @property Show\Field|Collection chr_title
     * @property Show\Field|Collection chr_fax
     * @property Show\Field|Collection chr_outlet
     * @property Show\Field|Collection chr_sub
     * @property Show\Field|Collection chr_ename
     * @property Show\Field|Collection int_boss
     * @property Show\Field|Collection login_disabled
     * @property Show\Field|Collection chr_sap
     * @property Show\Field|Collection int_no
     * @property Show\Field|Collection chr_visible
     * @property Show\Field|Collection int_force
     * @property Show\Field|Collection chr_pocode
     * @property Show\Field|Collection email_verified_at
     * @property Show\Field|Collection rb_user_id
     * @property Show\Field|Collection company_chinese_name
     * @property Show\Field|Collection company_english_name
     * @property Show\Field|Collection pocode
     * @property Show\Field|Collection operate_user_id
     * @property Show\Field|Collection cart_item_id
     * @property Show\Field|Collection order_date
     * @property Show\Field|Collection chr_phase
     * @property Show\Field|Collection po_no
     * @property Show\Field|Collection dept
     * @property Show\Field|Collection insert_date
     * @property Show\Field|Collection int_qty_init
     * @property Show\Field|Collection qty_received
     * @property Show\Field|Collection received_date
     * @property Show\Field|Collection reason
     * @property Show\Field|Collection order_price
     * @property Show\Field|Collection int_page
     * @property Show\Field|Collection int_all_shop
     * @property Show\Field|Collection shop_list
     * @property Show\Field|Collection int_main_item
     * @property Show\Field|Collection cut_time
     * @property Show\Field|Collection sampledate
     * @property Show\Field|Collection sample_id
     * @property Show\Field|Collection chr_sap_2
     * @property Show\Field|Collection int_unit_2
     * @property Show\Field|Collection image
     * @property Show\Field|Collection txt_detail_1
     * @property Show\Field|Collection txt_detail_2
     * @property Show\Field|Collection txt_detail_3
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
     * @method Show\Field|Collection cat_name(string $label = null)
     * @method Show\Field|Collection sort(string $label = null)
     * @method Show\Field|Collection status(string $label = null)
     * @method Show\Field|Collection start_date(string $label = null)
     * @method Show\Field|Collection end_date(string $label = null)
     * @method Show\Field|Collection id(string $label = null)
     * @method Show\Field|Collection product_no(string $label = null)
     * @method Show\Field|Collection product_name(string $label = null)
     * @method Show\Field|Collection group_name(string $label = null)
     * @method Show\Field|Collection last_modify(string $label = null)
     * @method Show\Field|Collection cat_id(string $label = null)
     * @method Show\Field|Collection short_name(string $label = null)
     * @method Show\Field|Collection report_name(string $label = null)
     * @method Show\Field|Collection num_of_day(string $label = null)
     * @method Show\Field|Collection int_hide(string $label = null)
     * @method Show\Field|Collection disabled(string $label = null)
     * @method Show\Field|Collection time(string $label = null)
     * @method Show\Field|Collection created_at(string $label = null)
     * @method Show\Field|Collection updated_at(string $label = null)
     * @method Show\Field|Collection log(string $label = null)
     * @method Show\Field|Collection txt_name(string $label = null)
     * @method Show\Field|Collection roles(string $label = null)
     * @method Show\Field|Collection email(string $label = null)
     * @method Show\Field|Collection guard_name(string $label = null)
     * @method Show\Field|Collection permissions(string $label = null)
     * @method Show\Field|Collection users(string $label = null)
     * @method Show\Field|Collection price(string $label = null)
     * @method Show\Field|Collection type(string $label = null)
     * @method Show\Field|Collection detail(string $label = null)
     * @method Show\Field|Collection is_enabled(string $label = null)
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
     * @method Show\Field|Collection value(string $label = null)
     * @method Show\Field|Collection username(string $label = null)
     * @method Show\Field|Collection password(string $label = null)
     * @method Show\Field|Collection avatar(string $label = null)
     * @method Show\Field|Collection remember_token(string $label = null)
     * @method Show\Field|Collection plan_no(string $label = null)
     * @method Show\Field|Collection max_claim_money(string $label = null)
     * @method Show\Field|Collection rate(string $label = null)
     * @method Show\Field|Collection type_name(string $label = null)
     * @method Show\Field|Collection times_per_day(string $label = null)
     * @method Show\Field|Collection times_per_year(string $label = null)
     * @method Show\Field|Collection employee_id(string $label = null)
     * @method Show\Field|Collection claim_level_id(string $label = null)
     * @method Show\Field|Collection approver_id(string $label = null)
     * @method Show\Field|Collection illness_id(string $label = null)
     * @method Show\Field|Collection claim_date(string $label = null)
     * @method Show\Field|Collection file_path(string $label = null)
     * @method Show\Field|Collection shop_id(string $label = null)
     * @method Show\Field|Collection deli_date(string $label = null)
     * @method Show\Field|Collection po(string $label = null)
     * @method Show\Field|Collection code(string $label = null)
     * @method Show\Field|Collection claim_level(string $label = null)
     * @method Show\Field|Collection is_worked(string $label = null)
     * @method Show\Field|Collection leave_date(string $label = null)
     * @method Show\Field|Collection connection(string $label = null)
     * @method Show\Field|Collection queue(string $label = null)
     * @method Show\Field|Collection payload(string $label = null)
     * @method Show\Field|Collection exception(string $label = null)
     * @method Show\Field|Collection failed_at(string $label = null)
     * @method Show\Field|Collection cat_ids(string $label = null)
     * @method Show\Field|Collection user_ids(string $label = null)
     * @method Show\Field|Collection forbidden_date(string $label = null)
     * @method Show\Field|Collection form_name(string $label = null)
     * @method Show\Field|Collection admin_role_id(string $label = null)
     * @method Show\Field|Collection created_date(string $label = null)
     * @method Show\Field|Collection modify_date(string $label = null)
     * @method Show\Field|Collection deleted_date(string $label = null)
     * @method Show\Field|Collection form_no(string $label = null)
     * @method Show\Field|Collection is_sample(string $label = null)
     * @method Show\Field|Collection sample_path(string $label = null)
     * @method Show\Field|Collection first_path(string $label = null)
     * @method Show\Field|Collection is_multi_print(string $label = null)
     * @method Show\Field|Collection group_id(string $label = null)
     * @method Show\Field|Collection model_type(string $label = null)
     * @method Show\Field|Collection model_id(string $label = null)
     * @method Show\Field|Collection front_group_id(string $label = null)
     * @method Show\Field|Collection group(string $label = null)
     * @method Show\Field|Collection item_id(string $label = null)
     * @method Show\Field|Collection it_support_no(string $label = null)
     * @method Show\Field|Collection itsupport_item_id(string $label = null)
     * @method Show\Field|Collection itsupport_detail_id(string $label = null)
     * @method Show\Field|Collection importance(string $label = null)
     * @method Show\Field|Collection machine_code(string $label = null)
     * @method Show\Field|Collection other(string $label = null)
     * @method Show\Field|Collection last_update_user(string $label = null)
     * @method Show\Field|Collection comment(string $label = null)
     * @method Show\Field|Collection complete_date(string $label = null)
     * @method Show\Field|Collection handle_staff(string $label = null)
     * @method Show\Field|Collection finished_start_time(string $label = null)
     * @method Show\Field|Collection finished_end_time(string $label = null)
     * @method Show\Field|Collection fee(string $label = null)
     * @method Show\Field|Collection contact_person(string $label = null)
     * @method Show\Field|Collection library_type(string $label = null)
     * @method Show\Field|Collection file_name(string $label = null)
     * @method Show\Field|Collection link_path(string $label = null)
     * @method Show\Field|Collection link_name(string $label = null)
     * @method Show\Field|Collection view_type(string $label = null)
     * @method Show\Field|Collection deleted_at(string $label = null)
     * @method Show\Field|Collection notice_id(string $label = null)
     * @method Show\Field|Collection notice_name(string $label = null)
     * @method Show\Field|Collection notice_no(string $label = null)
     * @method Show\Field|Collection expired_date(string $label = null)
     * @method Show\Field|Collection is_directory(string $label = null)
     * @method Show\Field|Collection is_test(string $label = null)
     * @method Show\Field|Collection token(string $label = null)
     * @method Show\Field|Collection product_id(string $label = null)
     * @method Show\Field|Collection shop_group_id(string $label = null)
     * @method Show\Field|Collection cuttime(string $label = null)
     * @method Show\Field|Collection phase(string $label = null)
     * @method Show\Field|Collection canordertime(string $label = null)
     * @method Show\Field|Collection base(string $label = null)
     * @method Show\Field|Collection min(string $label = null)
     * @method Show\Field|Collection check_id(string $label = null)
     * @method Show\Field|Collection weekday(string $label = null)
     * @method Show\Field|Collection r_order_id(string $label = null)
     * @method Show\Field|Collection qty(string $label = null)
     * @method Show\Field|Collection orderdates(string $label = null)
     * @method Show\Field|Collection order_no(string $label = null)
     * @method Show\Field|Collection repair_project_no(string $label = null)
     * @method Show\Field|Collection repair_location_id(string $label = null)
     * @method Show\Field|Collection repair_item_id(string $label = null)
     * @method Show\Field|Collection repair_detail_id(string $label = null)
     * @method Show\Field|Collection repair_order_id(string $label = null)
     * @method Show\Field|Collection shop_name(string $label = null)
     * @method Show\Field|Collection tel(string $label = null)
     * @method Show\Field|Collection fax(string $label = null)
     * @method Show\Field|Collection address(string $label = null)
     * @method Show\Field|Collection eng_address(string $label = null)
     * @method Show\Field|Collection int_area(string $label = null)
     * @method Show\Field|Collection oper_time(string $label = null)
     * @method Show\Field|Collection special_date(string $label = null)
     * @method Show\Field|Collection month(string $label = null)
     * @method Show\Field|Collection unit_id(string $label = null)
     * @method Show\Field|Collection product_name_short(string $label = null)
     * @method Show\Field|Collection supplier_id(string $label = null)
     * @method Show\Field|Collection base_unit_id(string $label = null)
     * @method Show\Field|Collection base_qty(string $label = null)
     * @method Show\Field|Collection base_price(string $label = null)
     * @method Show\Field|Collection default_price(string $label = null)
     * @method Show\Field|Collection weight(string $label = null)
     * @method Show\Field|Collection weight_unit(string $label = null)
     * @method Show\Field|Collection item_list(string $label = null)
     * @method Show\Field|Collection int_dept(string $label = null)
     * @method Show\Field|Collection address_id(string $label = null)
     * @method Show\Field|Collection chr_mobile(string $label = null)
     * @method Show\Field|Collection chr_officephone(string $label = null)
     * @method Show\Field|Collection chr_title(string $label = null)
     * @method Show\Field|Collection chr_fax(string $label = null)
     * @method Show\Field|Collection chr_outlet(string $label = null)
     * @method Show\Field|Collection chr_sub(string $label = null)
     * @method Show\Field|Collection chr_ename(string $label = null)
     * @method Show\Field|Collection int_boss(string $label = null)
     * @method Show\Field|Collection login_disabled(string $label = null)
     * @method Show\Field|Collection chr_sap(string $label = null)
     * @method Show\Field|Collection int_no(string $label = null)
     * @method Show\Field|Collection chr_visible(string $label = null)
     * @method Show\Field|Collection int_force(string $label = null)
     * @method Show\Field|Collection chr_pocode(string $label = null)
     * @method Show\Field|Collection email_verified_at(string $label = null)
     * @method Show\Field|Collection rb_user_id(string $label = null)
     * @method Show\Field|Collection company_chinese_name(string $label = null)
     * @method Show\Field|Collection company_english_name(string $label = null)
     * @method Show\Field|Collection pocode(string $label = null)
     * @method Show\Field|Collection operate_user_id(string $label = null)
     * @method Show\Field|Collection cart_item_id(string $label = null)
     * @method Show\Field|Collection order_date(string $label = null)
     * @method Show\Field|Collection chr_phase(string $label = null)
     * @method Show\Field|Collection po_no(string $label = null)
     * @method Show\Field|Collection dept(string $label = null)
     * @method Show\Field|Collection insert_date(string $label = null)
     * @method Show\Field|Collection int_qty_init(string $label = null)
     * @method Show\Field|Collection qty_received(string $label = null)
     * @method Show\Field|Collection received_date(string $label = null)
     * @method Show\Field|Collection reason(string $label = null)
     * @method Show\Field|Collection order_price(string $label = null)
     * @method Show\Field|Collection int_page(string $label = null)
     * @method Show\Field|Collection int_all_shop(string $label = null)
     * @method Show\Field|Collection shop_list(string $label = null)
     * @method Show\Field|Collection int_main_item(string $label = null)
     * @method Show\Field|Collection cut_time(string $label = null)
     * @method Show\Field|Collection sampledate(string $label = null)
     * @method Show\Field|Collection sample_id(string $label = null)
     * @method Show\Field|Collection chr_sap_2(string $label = null)
     * @method Show\Field|Collection int_unit_2(string $label = null)
     * @method Show\Field|Collection image(string $label = null)
     * @method Show\Field|Collection txt_detail_1(string $label = null)
     * @method Show\Field|Collection txt_detail_2(string $label = null)
     * @method Show\Field|Collection txt_detail_3(string $label = null)
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
