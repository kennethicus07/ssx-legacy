<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">

<head>
    <style>
        /* Style definitions for pdfs */

        /**********************************************************************/
        /* Default style definitions
      /**********************************************************************/

        /* General
      -----------------------------------------------------------------------*/
        body {
            background-color: #114C8D;
            color: #000033;
            font-family: "verdana", "sans-serif";
            margin: 0px;
            padding-top: 0px;
            font-size: 1em;
        }

        h1 {
            font-size: 1.2em;
            color: #114C8D;
            font-style: italic;
        }

        h2 {
            font-size: 1.1em;
            color: #114C8D;
        }

        h3 {
            font-size: 1em;
            color: #114C8D;
        }

        img {
            border: none;
        }

        img.border {
            border: 1px solid #114C8D;
        }

        pre {
            font-family: "verdana", "sans-serif";
            color: #FFFFff;
            font-size: 0.7em;
        }

        ul {
            color: #BEAC8B;
            list-style-type: circle;
            list-style-position: inside;
            margin: 0px;
            padding: 3px;
        }

        li {
            color: #000033;
        }

        li.alpha {
            list-style-type: lower-alpha;
            margin-left: 15px;
        }

        p {
            font-size: 0.8em;
        }

        a:link,
        a:visited {
            text-decoration: none;
            color: #114C8D;
        }

        a:hover {
            text-decoration: underline;
            color: #860000;
        }

        hr {
            border: 0;
        }

        #page_header {
            position: relative;
            /* required to make the z-index work */
            z-index: 2;
        }

        #body {
            background-color: #F9F0E9;
            padding: 12px 0.5% 2em 3px;
            min-height: 20em;
            margin: 0px;
            width: 100%;
        }

        #body pre {
            color: #000033;
        }

        #left_column {
            width: 84%;
            height: auto;
            padding-right: 8px;
            padding-bottom: 30px;
        }

        #right_column {
            /*  position: absolute;
        right: 0.5%;*/
            padding-left: 16px;
            width: 15%;
            min-width: 160px;
        }


        /* Inputs
      -----------------------------------------------------------------------*/
        input {
            color: #114C8D;
            border: 1px solid #114C8D;
            background-color: #FFFFff;
            font-family: "verdana", "sans-serif";
            font-size: 1em;
            padding-left: 3px;
        }

        select {
            color: #114C8D;
            border: 1px solid #114C8D;
            background-color: #FFFFff;
            font-family: "verdana", "sans-serif";
            font-size: 1em;
        }

        textarea {
            color: #114C8D;
            border: 1px solid #114C8D;
            background-color: #FFFFff;
            font-family: "verdana", "sans-serif";
            font-size: 1em;
        }

        a.button {
            color: #114C8D;
            border: 1px solid #114C8D;
            background-color: #FFFFff;
            font-size: 11px;
            font-weight: normal;
            /*  font-size: 0.75em; */
            -moz-border-radius: 4px;
            padding: 1px 6px 1px 6px;
            cursor: pointer;
            white-space: nowrap;
            text-align: center;
        }

        a.button:hover {
            text-decoration: none;
        }

        a.block_button {
            color: #114C8D;
            border: 1px solid #114C8D;
            background-color: #FFFFff;
            font-size: 11px;
            -moz-border-radius: 4px;
            padding: 1px 6px 1px 6px;
            cursor: pointer;
            white-space: nowrap;
            text-align: center;
            display: block;
        }

        a.block_button:hover {
            text-decoration: none;
        }

        input[type=button],
        input[type=submit],
        input[type=reset] {
            -moz-border-radius: 4px;
            cursor: pointer;
            font-size: 11px;
            /*  font-size: 0.75em; */
            padding: 0px 3px 0px 3px;
        }

        input[type=checkbox] {
            border: none;
        }

        input[disabled],
        input[readonly] {
            background-color: #dddddd;
        }

        input.ok {
            padding-left: 12px;
            background-image: url(/images/check.png);
            background-repeat: no-repeat;
            background-position: 3px center;
        }

        input.cancel {
            padding-left: 12px;
            background-image: url(/images/small_cancel.png);
            background-repeat: no-repeat;
            background-position: 3px center;
        }

        /* Footer
      -----------------------------------------------------------------------*/
        #footer {
            color: #FFFFff;
            border-top: 1px solid #000033;
        }

        #copyright {
            padding: 5px;
            font-size: 0.6em;
            background-color: #114C8D;
        }

        #footer_spacer_row {
            border-spacing: 0;
            width: 100%;
        }

        #footer_spacer_row td {
            padding: 0px;
            border-bottom: 1px solid #000033;
            background-color: #F7CF07;
            height: 2px;
            font-size: 2px;
            line-height: 2px;
        }

        #logos {
            padding: 5px;
            float: right;
        }


        /* Plugins
      -----------------------------------------------------------------------*/
        #plugin_box {
            width: 100%;
            min-width: 160px;
            padding: 0px;
            float: right;
            background-color: #EDF2F7;
            border: 1px solid #114C8D;
            margin: 0px 0px 2em 0px;
        }

        .plugin_header {
            font-size: 0.7em;
            font-weight: bold;
            padding: 2px;
            background-color: #114C8D;
            color: #FFFFff;
        }

        ul.side_menu_list>li {
            color: #BEAC8B;
        }

        ul.side_menu_list>li {
            font-size: 0.7em;
            font-weight: bold;
            margin-left: 0.5%;
            list-style-type: none;
        }

        ul.side_menu_sublist>li {
            font-size: 0.7em;
            color: black;
            font-weight: normal;
            margin-left: 10%;
            list-style-position: outside;
        }


        .plugin_shade {
            float: right;
        }


        #plugin_box p {
            font-size: 0.7em;
            margin: 0px 0px 3px 5%;
        }

        .plugin {
            border-spacing: 0px;
            width: 98%;
            margin: 3px auto 3px auto;
        }

        .plugin td {
            font-size: 0.7em;
        }

        .plugin td.field {
            background-color: #EDF2F7;
        }

        .plugin td.field_center {
            background-color: #EDF2F7;
        }

        .plugin td.label {
            background-color: #EDF2F7;
        }

        .plugin tr.foot td {
            text-align: center;
            font-size: 0.7em;
        }

        /* Menu
      -----------------------------------------------------------------------*/
        #main_menu {
            width: 100%;
            position: absolute;
            margin: 0px;
            font-size: 0.7em;
            background-color: #F9F0E9;
            z-index: 1;
        }

        #menu_group_head {
            margin: 0px;
            position: relative;
            background-color: #EDF2F7;
            white-space: nowrap;
            font-weight: bold;
            border-bottom: 1px solid #114C8D;
            padding: 3px 3px 2px 3px;
            color: #114C8D;
        }

        #menu_group_head>a {
            padding: 4px 6px 2px 6px;
        }

        #menu_group_head>a:hover {
            text-decoration: none;
            cursor: pointer;
            color: #FFFFff;
            background-color: #114C8D;
        }

        ul.menu_group {
            z-index: 2;
            position: absolute;
            display: none;
            background-color: #EDF2F7;
            border: 1px solid #114C8D;
            border-top: none;
            padding: 2px 0px 4px 0px;
        }

        ul.menu_group li {
            color: #114C8D;
            list-style: none;
            margin-top: 4px;
            margin-bottom: 4px;
            padding: 2px 12px 2px 12px;
            font-size: 1.05em;
        }

        ul.menu_group>a:hover,
        ul.menu_group>a:hover>li,
        ul.menu_group>a>li:hover {
            text-decoration: none;
            color: #114C8D;
            background-color: #DDE1E6;
        }

        /* Message area
      -----------------------------------------------------------------------*/
        #message_area {
            background-color: #EDF2F7;
            color: #000033;
            margin-left: 0.5%;
            /*  margin-right: 19.5%; */
            margin-bottom: 1em;
            padding: 0.2em 1% 0.5em 1%;
            border: 1px solid #114C8D;
        }

        #message_area h2 {
            margin: 0px 0px 0.5em 0px;
            font-size: 1em;
            font-style: italic;
        }

        .message {
            font-size: 0.8em;
        }

        /* Tooltips
      -----------------------------------------------------------------------*/
        .tooltip {
            display: none;
            position: absolute;
            font-size: 10px;
            line-height: 12px;
            width: 20em;
            background-color: #EDF2F7;
            border: 1px solid #114C8D;
            color: #114C8D;
            padding: 5px;
            z-index: 3;
        }

        /* Section Header
      -----------------------------------------------------------------------*/
        #section_header {
            /*  margin-right: 19.5%; */
            background-color: #BEAC8B;
            padding: 5px;
            margin-right: 8px;
            border: 1px solid #8B7958;
        }

        #job_info {
            font-weight: bold;
        }

        #job_buttons a.button {
            background-color: #E5D9C3;
        }

        .header_details {
            border-spacing: 0px;
        }

        .header_details td {
            font-size: 0.6em;
        }

        .header_label {
            padding-left: 20px;
            font-weight: bold;
        }

        .header_field {
            padding-left: 5px;
        }


        /* Content
      -----------------------------------------------------------------------*/
        .page_buttons {
            text-align: center;
            margin: 3px;
            font-size: 0.7em;
            white-space: nowrap;
            font-weight: bold;
            width: 74%;
        }

        .link_bar {
            white-space: nowrap;
            padding: 3px 0px 0px 0px;
            margin: -1px 8px 2em 0px;
            font-size: 0.7em;
            text-align: center;
        }

        .link_bar a {
            background-color: #E5D9C3;
            border: 1px solid #8B7958;
            -moz-border-radius-bottomleft: 4px;
            -moz-border-radius-bottomright: 4px;
            border-top: none;
            padding: 2px 3px 3px 3px;
            margin-right: 2px;
            white-space: nowrap;
        }

        .link_bar a.selected,
        .link_bar a:hover {
            background-color: #BEAC8B;
            color: #114C8D;
            padding-top: 3px;
            border: 1px solid #8B7958;
            border-top: none;
            text-decoration: none;
        }

        .page_menu li {
            margin: 5px;
            font-size: 0.8em;
        }


        /* Pop-Up
      -----------------------------------------------------------------------*/
        #popup_header {
            padding: 3px;
            text-align: center;
        }

        #popup_body {
            background-color: #F9F0E9;
            padding-bottom: 5px;
            padding-top: 5px;
        }

        #popup_content {
            padding: 0.2em 1% 0px 1%;
        }


        /* Tables
      -----------------------------------------------------------------------*/
        table {
            empty-cells: show;
        }

        .head td {
            color: #8B7958;
            background-color: #E5D9C3;
            font-weight: bold;
            font-size: 0.7em;
            padding: 3px;
        }

        .head input {
            font-weight: normal;
        }

        .sub_head td {
            border: none;
            white-space: nowrap;
            font-size: 10px;
        }

        .foot td {
            color: #8B7958;
            background-color: #E5D9C3;
            font-size: 0.8em;
        }

        .label {
            color: #8B7958;
            background-color: #F8F5F2;
            padding: 3px;
            font-size: 0.75em;
        }

        .label_right {
            color: #8B7958;
            background-color: #F8F5F2;
            padding: 3px;
            font-size: 0.75em;
            text-align: right;
            padding-right: 1em;
        }

        .sublabel {
            color: #8B7958;
            font-size: 0.6em;
            padding: 0px;
            text-align: center;
        }

        .field {
            color: #000033;
            background-color: #F9F0E9;
            padding: 3px;
            font-size: 0.75em;
        }

        .field_center {
            color: #000033;
            background-color: #F9F0E9;
            padding: 3px;
            font-size: 0.75em;
            text-align: center;
        }

        .field_nw {
            color: #000033;
            background-color: #F9F0E9;
            padding: 3px;
            font-size: 0.75em;
            white-space: nowrap;
        }

        .field_money {
            color: #000033;
            background-color: #F9F0E9;
            padding: 3px;
            font-size: 0.75em;
            white-space: nowrap;
            text-align: right;
        }

        .field_total {
            color: #000033;
            background-color: #F9F0E9;
            padding: 3px;
            font-size: 0.75em;
            white-space: nowrap;
            text-align: right;
            font-weight: bold;
            border-top: 1px solid black;
        }

        /* Table Data
      -----------------------------------------------------------------------*/
        .h_scrollable {
            overflow: -moz-scrollbars-horizontal;
        }

        .v_scrollable {
            overflow: -moz-scrollbars-vertical;
        }

        .scrollable {
            overflow: auto;
            /*-moz-scrollbars-horizontal;*/
        }

        tr.head>td.center,
        tr.list_row>td.center,
        .center {
            text-align: center;
        }

        .left,
        tr.head>td.left,
        tr.list_row>td.left {
            text-align: left;
            padding-left: 2em;
        }

        .total,
        .right,
        .list tr.head td.right,
        tr.list_row td.right,
        tr.foot td.right,
        tr.foot td.total {
            text-align: right;
            padding-right: 2em;
        }

        .list tr.foot td {
            font-weight: bold;
        }

        .no_wrap {
            white-space: nowrap;
        }

        .bar {
            border-top: 1px solid black;
        }

        .total {
            font-weight: bold;
        }

        .summary_spacer_row {
            line-height: 2px;
        }

        .light {
            color: #999999;
        }

        /* Detail
      -----------------------------------------------------------------------*/
        .fax_head,
        .narrow,
        .detail {
            border-spacing: 0px;
            border-top: 1px solid #8B7958;
            /* border-bottom: 1px solid #8B7958; */
            width: 99%;
            padding: 3px;
            margin-bottom: 10px;
        }

        .detail td.label {
            width: 16%;
            background-color: #F9F0E9;
        }

        .detail td.field {
            width: 33%;
            text-align: center;
            background-color: #F8F5F2;
        }

        .detail_spacer_row td {
            background-color: #BEAC8B;
            font-size: 2px;
            line-height: 2px;
            padding: 0px;
            border-top: 1px solid #F9F0E9;
            border-bottom: 1px solid #F9F0E9;
        }

        .detail td.field_money {
            width: 33%;
            background-color: #F8F5F2;
        }

        .narrow {
            width: 60%;
        }

        .narrow td.label {
            width: 50%;
            background-color: #F9F0E9;
        }

        .narrow td.field_money,
        .narrow td.field_total,
        .narrow td.field {
            width: 49%;
        }

        .narrow td.field_money,
        .narrow td.field {
            background-color: #F8F5F2;
        }

        .narrow td.field_total,
        .narrow td.field_money {
            padding-right: 4em;
        }

        .detail td.field {
            text-align: center;
            background-color: #F8F5F2;
        }

        .fax_head td.label {
            width: 7%;
        }

        .fax_head td.field {
            width: 26%;
        }

        .operation {
            width: 1%;
        }

        /* Wizards
      -----------------------------------------------------------------------*/
        .wizard {
            /*  border-spacing: 0px; */
            border-top: 1px solid #8B7958;
            border-bottom: 1px solid #8B7958;
        }

        .wizard_buttons {
            font-size: 0.75em;
            margin: 3px;
        }

        /* Forms
      -----------------------------------------------------------------------*/
        .form {
            /*  border-spacing: 0px; */
            border-top: 1px solid #8B7958;
            border-bottom: 1px solid #8B7958;
            padding: 1px;
        }

        .form tr.head input {
            font-weight: normal;
        }

        .form tr.head td {
            padding: 2px;
        }

        .form tr.foot td {
            text-align: center;
            padding: 2px;
        }


        /* Lists
      -----------------------------------------------------------------------*/
        .list {
            border-collapse: collapse;
            border-spacing: 0px;
            border-top: 1px solid #8B7958;
            border-bottom: 1px solid #8B7958;
            width: 99%;
            margin-top: 3px;
        }

        .list tr.head td {
            font-size: 0.7em;
            white-space: nowrap;
            padding-right: 0.65em;
            border-bottom: 1px solid #8B7958;
        }

        .list table.sub_head td {
            border: none;
            white-space: nowrap;
            font-size: 10px;
        }

        .list tr.foot td {
            border-top: 1px solid #8B7958;
            font-size: 0.7em;
        }

        tr.list_row>td {
            background-color: #EDF2F7;
            border-bottom: 1px dotted #8B7958;
            font-size: 0.65em;
            padding: 3px;
        }

        tr.list_row:hover td {
            background-color: #F8EEE4;
        }

        tr.problem_row>td {
            background-color: #FDCCCC;
            border-bottom: 1px dotted #8B7958;
            font-size: 0.65em;
            padding: 3px;
        }

        tr.problem_row:hover td {
            background-color: #F8EEE4;
        }

        .row_form td {
            font-size: 0.7em;
            padding: 3px;
            white-space: nowrap;
            /*  text-align: center; */
        }

        .row_form td.label {
            text-align: left;
            white-space: normal;
        }

        .inline_header td {
            color: #8B7958;
            font-size: 0.6em;
            white-space: nowrap;
            text-align: center;
        }

        /* Sub-Tables
      -----------------------------------------------------------------------*/
        .sub_table {
            border-spacing: 0px;
        }

        .sub_table tr.head td {
            font-size: 11px;
            padding: 3px;
            background-color: #F9F0E9;
        }

        .sub_table td {
            padding: 3px;
        }

        /* Reports
      -----------------------------------------------------------------------*/
        .report {
            border-collapse: collapse;
            border-spacing: 0px;
            border-top: 1px solid #8B7958;
            border-bottom: 1px solid #8B7958;
            width: 80%;
            margin-top: 3px;
        }

        .report tr td {
            padding: 4px 6px;
        }

        .report tr.head td {
            font-size: 0.7em;
            white-space: nowrap;
            text-align: center;
            border-bottom: 1px solid #8B7958;
        }

        .report tr.foot td {
            font-size: 0.7em;
            border-top: 1px solid #8B7958;
        }

        .report tr.list_row>td {
            background-color: #EDF2F7;
            border-bottom: 1px dotted #8B7958;
            font-size: 0.65em;
        }

        .report tr.list_row:hover td {
            background-color: #F8EEE4;
        }

        .report td.total_col {
            font-weight: bold;
            border-left: 1px dotted #8B7958;
            text-align: center;
            width: 10%;
        }

        .report tr.head td.group_col {
            text-align: left;
        }

        .report td.group_col {
            font-weight: bold;
            text-align: left;
            border-right: 1px dotted #8B7958;
            width: 12%;
        }

        .graph {
            width: 80%;
            margin-top: 2em;
            margin-bottom: 3em;
            text-align: center;
        }


        /* Notifications
      -----------------------------------------------------------------------*/
        .notification_list {
            border-collapse: collapse;
            border-spacing: 0px;
            border-top: 1px solid #8B7958;
            border-bottom: 1px solid #8B7958;
            width: 99%;
        }

        .notification_list tr.head td {
            font-size: 0.65em;
            white-space: nowrap;
            text-align: center;
            border-bottom: 1px solid #8B7958;
        }

        .notification_list tr.foot td {
            border-top: 1px solid #8B7958;
        }

        .notification_list tr.list_row td {
            padding: 7px;
        }

        div.notif_list_text {
            margin-bottom: 1px;
            font-size: 1.1em;
        }

        .list_row>td.notif_list_job {
            white-space: nowrap;
            text-align: center;
            font-weight: bold;
            font-size: 0.65em;
            white-space: nowrap;
        }

        /* Some of the system messages are long and look bad with a highlighted
      background... */
        #system_notif_table tr.list_row:hover>td {
            background-color: #EDF2F7;
        }

        .notif_select_column {
            width: 2%;
            padding: 0px;
            text-align: center;
        }

        .notif_job_column {
            width: 8%;
            white-space: nowrap;
            padding-left: 0px;
            font-weight: bold;
            text-align: center;
        }

        .notif_notif_column {
            width: auto;
        }

        .notif_date_column {
            width: 15%;
            text-align: center;
            white-space: nowrap;
            padding-right: 3px;
        }



        /* Notes
      -----------------------------------------------------------------------*/
        /* Note Table */
        table#topic_list {
            border-bottom: 1px solid #E5D9C3;
            border-collapse: separate;
        }

        /* Note Form */
        .note_form {
            background-color: #F9F0E9;
            position: absolute;
            left: 20%;
            display: none;
            border: 2px solid #114C8D;
        }

        .note_form table.form {
            margin-top: 2em;
        }

        .handle {
            background-color: #114C8D;
            color: #FFFFff;
            margin-bottom: 3px;
            height: 16px;
        }

        .note_form_close {
            font-weight: bold;
            font-size: 9px;
            padding: 0px 2px 0px 2px;
            margin-right: 2px;
            position: absolute;
            right: 0%;
            border: 1px solid #114C8D;
        }

        a.note_form_close:hover {
            text-decoration: none;
        }

        .list_row:hover>td table.add_note tr.add_note_foot td,
        .list_row:hover>td table.add_note tr.add_note_head td {
            background-color: #E5D9C3;
        }

        .list_row:hover>td table.add_note tr td {
            background-color: #F9F0E9;
        }

        .add_note td {
            border: none;
            padding: 3px;
            background-color: #F9F0E9;
            font-size: 9px;
        }

        .add_note_head td {
            background-color: #E5D9C3;
            border-top: 1px solid #8B7958;
            border-bottom: 1px solid #8B7958;
            color: #8B7958;
            padding: 3px;
            text-align: center;
            font-weight: bold;
            font-size: 9px;
        }

        .add_note input {
            color: #114C8D;
            background-color: #FFFFff;
            border: 1px solid #114C8D;
            padding: 1px 2px 1px 2px;
            text-decoration: none;
            font-size: 9px;
        }

        .add_note textarea {
            color: #114C8D;
            background-color: #FFFFff;
            border: 1px solid #114C8D;
            padding: 1px 2px 1px 2px;
            font-family: "verdana", "sans-serif";
            font-size: 9px;
        }

        .add_note select {
            color: #114C8D;
            background-color: #FFFFff;
            font-size: 9px;
        }

        .add_note_foot td {
            background-color: #E5D9C3;
            border-bottom: 1px solid #8B7958;
            color: #8B7958;
            padding: 3px;
            text-align: center;
            font-weight: bold;
            font-size: 9px;
        }

        /* Note List */
        .note>td {
            background-color: #EDF2F7;
            padding-left: 10px;
            border-bottom: 1px dotted #E5D9C3;
        }

        .note:hover>td,
        .note:hover>td>p {
            background-color: #EDF2F7;
        }

        .note_author {
            font-size: 0.65em;
            text-align: center;
            border-right: 1px dotted #E5D9C3;
        }

        .note p {
            margin-left: 3%;
            font-size: 0.75em;
            background-color: #EDF2F7;
        }

        .topic_spacer td {
            border-bottom: 1px solid #8B7958;
            line-height: 2px;
        }

        td.note_indent {
            background-color: #F9F0E9;
            width: 2%;
            border-bottom: none;
        }

        .note_control td {
            padding-left: 2%;
            padding-bottom: 1%;
            font-weight: normal;
            font-size: 0.6em;
            background-color: #EDF2F7;
            border-bottom: 1px dotted #E5D9C3;
        }

        .topic_title {
            font-size: 0.8em;
            font-weight: bold;
        }

        .note_title {
            font-size: 0.8em;
        }

        .problem .topic_title {
            color: #860000;
        }

        .thread>tr {
            display: none;
        }

        /* Summaries
      -----------------------------------------------------------------------*/
        .summary {
            border: 1px solid black;
            background-color: white;
            padding: 1%;
            font-size: 0.8em;
        }

        .summary h1 {
            color: black;
            font-style: normal;
        }

        /* Print preview
      -----------------------------------------------------------------------*/
        .page {
            background-color: white;
            padding: 0px;
            border: 1px solid black;
            /*  font-size: 0.7em; */
            width: 95%;
            margin-bottom: 15px;
            margin-right: 5px;
            padding: 20px;
        }

        .page table.header td {
            padding: 0px;
        }

        .page table.header td h1 {
            padding: 0px;
            margin: 0px;
        }

        .page h1 {
            color: black;
            font-style: normal;
            font-size: 1.3em;
        }

        .page h2 {
            color: black;
        }

        .page h3 {
            color: white;
            font-size: 1em;
        }

        .page p {
            text-align: justify;
            font-size: 0.8em;
        }

        .page table {
            font-size: 0.8em;
        }

        .page em {
            font-weight: bold;
            font-style: normal;
            text-decoration: underline;
            margin-left: 1%;
            margin-right: 1%;
        }

        .page table.money_table {
            font-size: 1.1em;
            border-collapse: collapse;
            width: 85%;
            margin-left: auto;
            margin-right: auto;
        }

        .page table.money_table tr.foot td {
            font-size: 1em;
            border-top: 0.4pt solid black;
            font-weight: bold;
            background-color: white;
            color: black;
        }

        .page table.money_table tr.foot td.right {
            padding-right: 1px;
        }

        .written_field {
            border-bottom: 1px solid black;
        }

        .page .written_field {
            border-bottom: 0.4pt solid black;
        }

        .page .indent * {
            margin-left: 4em;
        }

        .checkbox {
            border: 1px solid black;
            padding: 1px 2px;
            font-size: 7px;
            font-weight: bold;
        }


        table.signature_table {
            width: 80%;
            font-size: 0.7em;
            margin: 2em auto 2em auto;
        }

        table.signature_table tr td {
            padding-top: 1.5em;
            vertical-align: top;
            white-space: nowrap;
        }

        #special_conditions {
            font-size: 1.3em;
            font-style: italic;
            margin-left: 2em;
            font-weight: bold;
        }

        .sa_head p {
            font-size: 1em;
        }


        .page hr {
            border-bottom: 1px solid black;
        }

        .page table.detail,
        .page table.fax_head {
            margin-left: auto;
            margin-right: auto;
        }

        .page .narrow,
        .page .fax_head {
            border: none;
        }

        .page tr.head td {
            color: black;
            background-color: #eee;
        }

        .page td.label {
            color: black;
            background-color: white;
            width: 20%;
        }

        .page td.label_right {
            color: black;
            background-color: white;
        }

        .page td.field {
            background-color: white;
            font-weight: bold;
        }

        .page td.field_money {
            background-color: white;
        }

        .page td.field_total {
            font-weight: bold;
            background-color: white;
        }

        .page tr.detail_spacer_row td {
            background-color: white;
            border-top: 1px solid black;
        }

        .page .header {
            border-spacing: 0px;
            border-collapse: collapse;
            padding: 0px;
        }

        .page .header tr td {
            border-top: 1px solid black;
            border-bottom: 1px solid black;
            background-color: #eee;
        }

        /* Style definitions for printable pages */


        /* Hide non-printing stuff
      -----------------------------------------------------------------------*/
        #page_header,
        #main_menu,
        #right_column,
        #footer {
            display: none;
        }

        /* General
      -----------------------------------------------------------------------*/
        @page {
            margin: 0.25in;
        }

        body {
            background-color: white;
            color: black;
        }

        h1 {
            color: black;
        }

        h2 {
            color: black;
        }

        pre {
            color: black;
        }

        ul {
            color: black;
        }

        a:link,
        a:visited {
            color: black;
        }

        a:hover {
            text-decoration: none;
            color: black;
        }

        p a {
            display: none;
        }

        #body {
            background-color: white;
        }

        #body pre {
            color: black;
        }

        /* Inputs
      -----------------------------------------------------------------------*/
        input {
            color: black;
            border: 1px solid black;
            background-color: white;
        }

        select {
            color: black;
            border: 1px solid black;
            background-color: white;
        }

        textarea {
            color: black;
            border: 1px solid black;
            background-color: white;
        }

        a.button {
            display: none;
        }

        a.block_button {
            display: none;
        }

        input[type=button],
        input[type=submit],
        input[type=reset] {
            display: none;
        }

        /* Tooltips
      -----------------------------------------------------------------------*/
        .tooltip {
            display: none;
        }

        /* Message area
      -----------------------------------------------------------------------*/
        #message_area {
            display: none;
        }

        /* Section Header
      -----------------------------------------------------------------------*/
        #section_header {
            background-color: #ddd;
            border: 1px dashed #666;
        }

        /* Content
      -----------------------------------------------------------------------*/
        .page_buttons {
            display: none;
        }

        .link_bar {
            display: none;
        }

        /* Tables
      -----------------------------------------------------------------------*/
        .head td {
            color: black;
            background-color: white;
        }

        .head input {}

        .foot td {
            color: black;
            background-color: white;
        }

        .label {
            color: black;
            background-color: white;
        }

        .sublabel {
            color: black;
        }

        .field {
            color: black;
            background-color: white;
        }

        .field_center {
            color: black;
            background-color: white;
        }

        .field_nw {
            color: black;
            background-color: white;
        }

        .field_money {
            color: black;
            background-color: white;
        }

        .field_total {
            color: black;
            background-color: white;
        }

        /* Detail
      -----------------------------------------------------------------------*/
        /* .detail {
                  border-top: 1px solid black;
                  border-bottom: 1px solid black;
              } */

        .detail {
            border-collapse: collapse;
            width: 100%;
            border: 1px solid #000;

        }

        .detail td,
        .detail th {
            border: 1px solid #000;
            padding: 4px 6px;
            vertical-align: top;

        }

        .detail th {
            background-color: #000;
            color: #fff;
            font-weight: bold;
            text-align: left;
        }

        .detail td.label {
            background-color: white;
        }

        .detail td.field_total,
        .detail td.field {
            font-weight: bold;
            background-color: #eee;
        }

        .detail td.field_money {
            background-color: #eee;
        }

        .detail_spacer_row td {
            background-color: white;
            border-top: 1px solid black;
            border-bottom: 1px solid black;
        }

        .narrow td.label {
            background-color: white;
        }

        .narrow td.field {
            background-color: #eee;
        }

        /* Wizards
      -----------------------------------------------------------------------*/
        .wizard {
            border-top: 1px solid black;
            border-bottom: 1px solid black;
        }

        /* Forms
      -----------------------------------------------------------------------*/
        .form {
            border-top: 1px solid black;
            border-bottom: 1px solid black;
        }

        /* Lists
      -----------------------------------------------------------------------*/
        .list {
            border-top: 1px solid black;
            border-bottom: 1px solid black;
        }

        .list tr.head>td {
            border-bottom: 1px solid black;
        }

        .list tr.foot td {
            border-top: 1px solid black;
        }

        tr.list_row>td {
            background-color: white;
            border-bottom: 1px dotted #666;
        }

        tr.list_row:hover td {
            background-color: white;
        }

        /* Notifications
      -----------------------------------------------------------------------*/
        .notification_list {
            border-top: 1px solid black;
            border-bottom: 1px solid black;
        }

        .notification_list tr.head td {
            border-bottom: 1px solid black;
        }

        .notification_list tr.foot td {
            border-top: 1px solid black;
        }

        #system_notif_table tr.list_row:hover>td {
            background-color: white;
        }

        /* Notes
      -----------------------------------------------------------------------*/
        /* Note Table */
        table#topic_list {
            border-bottom: 1px solid #eee;
        }

        /* Note Form */
        .note_form {
            display: none;
        }

        /* Note List */
        .note>td {
            background-color: white border-bottom: 1px dotted #eee;
        }

        .note:hover>td,
        .note:hover>td>p {
            background-color: white;
        }

        .note_author {
            border-right: 1px dotted #eee;
        }

        .note td {
            background-color: white;
        }

        .note p {
            background-color: white;
        }

        .topic_spacer td {
            border-bottom: 1px solid black;
        }

        td.note_indent {
            background-color: white;
        }

        .note_control td {
            background-color: white;
            border-bottom: 1px dotted #eee;
        }

        .problem .topic_title {
            color: black;
        }

        /* Summaries
      -----------------------------------------------------------------------*/
        .summary {
            border: 1px solid black;
            background-color: white;
        }

        .summary h1 {
            color: black;
        }

        /* Pages
      -----------------------------------------------------------------------*/
        .page>*>p,
        .page>p {
            font-size: 1.5em;
        }

        .written_field {
            font-size: 1em;
            border-bottom: 1px solid black;
        }

        .page h1 {
            font-size: 1em;
        }

        .page h2 {
            font-size: 0.9em;
            margin-top: 5px;
            margin-bottom: 5px;
        }

        @page {
            margin-bottom: 0.75in;
        }

        /* General
      -----------------------------------------------------------------------*/
        body {
            background-color: white;
        }

        /* Detail
      -----------------------------------------------------------------------*/

        .narrow td.field,
        .detail td.field {
            text-align: left;
            padding-left: 1em;
            background-color: white;
        }

        /* Lists
      -----------------------------------------------------------------------*/
        .list tr.head td {
            background-color: #eee;
        }

        tr.list_row>td {
            background-color: white;
            border-bottom: 0.7pt dotted #666;
        }

        .list tr.foot td {
            background-color: #eee;
        }

        /* Pages
      -----------------------------------------------------------------------*/
        .page {
            font-size: 1em;
            border: none;
            margin: none;
            width: auto;
            padding: 0px;
        }

        .foot td {
            font-size: 1em;
        }


        .page>*>p,
        .page>p {
            font-size: 0.8em;
        }


        table.signature_table {
            width: 88%;
            font-size: 0.6em;
        }

        #special_conditions {
            font-size: 1.5em;
        }

        .header h1 {
            font-size: 0.8em;
        }

        p.small {
            font-size: 0.8em;
        }

        .page td {
            padding: 1px;
            border: 1px solid black;
        }

        td.label {
            font-size: 0.7em;
        }

        td.field {
            font-size: 0.7em;
        }

        td.field_money {
            font-size: 0.7em;
        }
    </style>
</head>

<body class="page">
    <!-- Logo alone at the top -->
    <!-- Top Logos -->
    <table style="width: 100%; margin-bottom: 20px;">
        <tr>
            <!-- Left logo -->
            <td style="text-align: left; border:none;">
                <img src="{{ env('APP_URL') }}/assets/images/ssx-logo-conforme.png" alt="Left Logo" style="height: 40px;">
            </td>

            <!-- Right logo -->
            <td style="text-align: right; border:none;">
                <img src="{{ env('APP_URL') }}/assets/images/dti-citem.png" alt="Right Logo" style="height: 40px;">
            </td>
        </tr>
    </table>


    <table align="center">
        <tr>
            <td style="border:none; text-align: center;">
                <h1>SUSTAINABILITY SOLUTIONS EXCHANGE — SUMMARY OF APPLICATION (SUPPLIER/EXHIBITOR)</h1>
            </td>
        </tr>
    </table>

    <table style="width: 100%" class="header">
        <tr>
            <td style="text-align: right;">
                <span style="font-weight: bold; font-size: 0.7em;">
                    {{ $cur_date ?? now()->format('jS \o\f F, Y') }}
                </span>
            </td>
        </tr>
    </table>
    {{-- Event Information --}}
    <table class="detail" style="margin: 0px; border: none;">
        <tr>
            <td colspan="4" style="text-align: center; border:none;">
                <h2>Event Information</h2>
            </td>
        </tr>
        <tr>
            <td class="label">Name:</td>
            <td class="field" colspan="3">{{ $event->event_name ?? '—' }}</td>

        </tr>
        <tr>
            <td class="label">Address:</td>
            <td class="field" colspan="3">{{ $event->location ?? '—' }}</td>

        <tr>
            <td class="label">Date:</td>
            <td class="field" colspan="3">
                @php
                    use Carbon\Carbon;
                    $startDate = isset($event->event_start)
                        ? Carbon::parse($event->event_start)->format('F j, Y')
                        : '—';
                    $endDate = isset($event->event_end) ? Carbon::parse($event->event_end)->format('F j, Y') : '—';
                @endphp
                {{ $startDate }}{{ $event->event_end ? ' – ' . $endDate : '' }}
            </td>
        </tr>
        </tr>
    </table>
    <table class="detail" style="margin: 0px; border:none;">
        <tr>
            <td colspan="4" style="text-align: center; border:none;">
                <h2>Company Information</h2>
            </td>
        </tr>
        <tr>
            <td class="label">Supplier/Exhibitor Type:</td>
            <td class="field"> {{ \App\Models\Exhibitor::getExhibitorTypeLabel($exhibitor->exhibitor_type) }}</td>
            <td class="label">Last Participated Year:</td>
            <td class="field">{{ $exhibitor->last_participated_year ?? '—' }}</td>
        </tr>
        <tr>
            <td class="label">Company Name:</td>
            <td class="field">{{ $exhibitor->co_name ?? '—' }}</td>
            <td class="label">Directory name:</td>
            <td class="field">{{ $exhibitor->directory_name ?? '—' }}</td>
        </tr>
        <tr>
            <td class="label">Phone Number:</td>
            <td class="field">{{ $exhibitor->phone_country_code ?? '' }} {{ $exhibitor->phone_area_code ?? '' }}
                {{ $exhibitor->phone_no ?? '' }}</td>
            <td class="label">Mobile Number:</td>
            <td class="field">{{ $exhibitor->mobile_country_code ?? '' }} {{ $exhibitor->mobile_no ?? '' }}</td>
        </tr>
        <tr>
            <td class="label">Website:</td>
            <td class="field">{{ $exhibitor->website ?? '—' }}</td>
            <td class="label">Company E-mail Address:</td>
            <td class="field">{{ $exhibitor->co_email ?? '—' }}</td>
        </tr>
    </table>

    {{-- Corporate Social Media --}}
    <table class="detail" style="margin: 0px; border: none;">
        <tr>
            <td colspan="4" style="text-align: center; border:none;">
                <h2>Corporate Social Media Account</h2>
            </td>
        </tr>
        @foreach (['Facebook' => 'facebook', 'Twitter' => 'twitter', 'Instagram' => 'instagram', 'LinkedIn' => 'linkedin'] as $label => $field)
            <tr>
                <td class="label">{{ $label }}:</td>
                <td class="field" colspan="3">
                    @if (!empty($exhibitor->{$field}))
                        https://www.{{ strtolower($label) }}.com/{{ $exhibitor->{$field} }}
                    @else
                        -
                    @endif
                </td>
            </tr>
        @endforeach
        <tr>
            <td class="label">Others:</td>
            <td class="field" colspan="3">{{ $exhibitor->other_social ?? '—' }}</td>
        </tr>


    </table>

    {{-- Factory Address --}}
    <table class="detail" style="margin:0px;border:none;">
        <tr>
            <td colspan="4" style="text-align: center; border:none;">
                <h2>Factory Address</h2>
            </td>
        </tr>
        <tr>
            <td class="label">Country:</td>
            <td class="field">{{ optional($exhibitor->factory_country)->name ?? '—' }}</td>
            <td class="label">Province/State:</td>
            <td class="field">{{ $exhibitor->fa_state ?? '—' }}</td>
        </tr>
        <tr>
            <td class="label">City/Town:</td>
            <td class="field">{{ $exhibitor->fa_city ?? '—' }}</td>
            <td class="label">Zipcode:</td>
            <td class="field">{{ $exhibitor->fa_zipcode ?? '—' }}</td>
        </tr>
        <tr>
            <td class="label">Region:</td>
            <td class="field">{{ $exhibitor->fa_region ?? '—' }}</td>
            <td class="label">Street:</td>
            <td class="field">{{ $exhibitor->fa_street ?? '—' }}</td>
        </tr>
    </table>
    {{-- Main Office --}}
    <table class="detail" style="margin: 0px; border:none;">

        <tr>
            <td colspan="4" style="text-align: center; border:none;">
                <h2>Main Office Address</h2>
            </td>
        </tr>
        <tr>
            <td class="label">Country:</td>
            <td class="field">{{ optional($exhibitor->main_country)->name ?? '—' }}</td>
            <td class="label">Province/State:</td>
            <td class="field">{{ $exhibitor->moa_state ?? '—' }}</td>
        </tr>
        <tr>
            <td class="label">City/Town:</td>
            <td class="field">{{ $exhibitor->moa_city ?? '—' }}</td>
            <td class="label">Zipcode:</td>
            <td class="field">{{ $exhibitor->moa_zipcode ?? '—' }}</td>
        </tr>
        <tr>
            <td class="label">Region:</td>
            <td class="field">{{ $exhibitor->moa_region ?? '—' }}</td>
            <td class="label">Street:</td>
            <td class="field">{{ $exhibitor->moa_street ?? '—' }}</td>
        </tr>
    </table>

    {{-- Contact Info --}}
<table class="detail" style="margin: 0px; border: none;">
    <tr>
        <td colspan="6" style="border: none; text-align: center; border: none;">
            <h2>Contact Information</h2>
        </td>
    </tr>

    <tr>
        <td colspan="6" style="text-align: center;">
            <h2>Business Owner</h2>
        </td>
    </tr>

    <tr>
        <td class="label">Salutation:</td>
        <td class="field">{{ $b_owner->salutation ?? '—' }}</td>
        <td class="label">Firstname:</td>
        <td class="field">{{ $b_owner->fname ?? '—' }}</td>
        <td class="label">Lastname:</td>
        <td class="field">{{ $b_owner->lname ?? '—' }}</td>
    </tr>

    <tr>
        <td class="label">M.I.:</td>
        <td class="field">{{ $b_owner->mi ?? '' }}</td>
        <td class="label">Designation:</td>
        <td class="field">{{ $b_owner->designation ?? '—' }}</td>
        <td class="label">E-mail:</td>
        <td class="field">{{ $b_owner->email ?? '—' }}</td>
    </tr>

    <tr>
        <td class="label">Mobile No.:</td>
        <td class="field" colspan="5">
            {{ $b_owner->country_code ?? '' }} {{ $b_owner->mobile_no ?? '' }}
        </td>
    </tr>

    <tr>
        <td colspan="6" style="text-align: center;">
            <h2>Business Contact Person</h2>
        </td>
    </tr>

    <tr>
        <td class="label">Salutation:</td>
        <td class="field">{{ $b_contact_person->salutation ?? '—' }}</td>
        <td class="label">Firstname:</td>
        <td class="field">{{ $b_contact_person->fname ?? '—' }}</td>
        <td class="label">Lastname:</td>
        <td class="field">{{ $b_contact_person->lname ?? '—' }}</td>
    </tr>

    <tr>
        <td class="label">M.I.:</td>
        <td class="field">{{ $b_contact_person->mi ?? '' }}</td>
        <td class="label">Designation:</td>
        <td class="field">{{ $b_contact_person->designation ?? '—' }}</td>
        <td class="label">E-mail:</td>
        <td class="field">{{ $b_contact_person->email ?? '—' }}</td>
    </tr>

    <tr>
        <td class="label">Mobile No.:</td>
        <td class="field" colspan="5">
            {{ $b_contact_person->country_code ?? '' }}
            {{ $b_contact_person->mobile_no ?? '' }}
        </td>
    </tr>
</table>

    {{-- Business Info --}}
    <table class="detail" style="margin: 0px; border: none;">
        <tr>
            <td colspan="4" style="text-align: center; border:none; ">
                <h2>Business Information</h2>
            </td>
        </tr>
        <tr>
            <td class="label">Start up:</td>
            <td class="field " colspan="3">{{ $exhibitor->start_up ? 'Yes' : 'No' }}</td>
        </tr>
        <tr>
            <td class="label">Interested in SSX Conference?:</td>
            <td class="field " colspan="3">{{ $attendance_info->conference_response ? 'Yes' : 'No' }}</td>
        </tr>
        <tr>
            <td class="label">Interested in becoming a sponsorin SSX 2026?:</td>
            <td class="field " colspan="3">{{ $attendance_info->sponsorship_response ? 'Yes' : 'No' }}</td>
        </tr>
        <tr>
            <td class="label">Business Registration:</td>
            <td class="field">{{ $exhibitor->business_registration_type->name ?? '—' }}</td>
            <td class="label">Company Size:</td>
            <td class="field">{{ $exhibitor->company_size->name ?? '—' }}</td>
        </tr>
        <tr>
            <td class="label">Annual Sales Volume:</td>
            <td class="field">{{ $exhibitor->annual_sales_volume->name ?? '—' }}</td>
            <td class="label">Type of Organization:</td>
            <td class="field">{{ $exhibitor->organization_type->name ?? '—' }}</td>
        </tr>
        <tr>
            <td class="label">Direct Workers:</td>
            <td class="field">{{ $exhibitor->direct_workers ?? '—' }}</td>
            <td class="label">Indirect/Sub-Contractors:</td>
            <td class="field">{{ $exhibitor->indirect_workers ?? '—' }}</td>
        </tr>
        <tr>
            <td class="label">Nature Business:</td>
            <td class="field" colspan="3">{{ $nature_business ?? '—' }}</td>
        </tr>
        <tr>
            <td class="label">Target Buyer & Intent:</td>
            <td class="field" colspan="3">{{ $target_buyers ?? '—' }}</td>
        </tr>
        <tr>
            <td class="label">Target Countries For Export (Top 3):</td>
            <td class="field" colspan="3">{{ $target_countries ?? '—' }}</td>
        </tr>
        <tr>
            <td class="label">Certification:</td>
            <td class="field" colspan="3">{{ $certification ?? '—' }}</td>
        </tr>
        <tr>
            <td class="label">Industry Representation:</td>
            @if ($exhibitor->industry_rep === 1)
                <td class="field" colspan="3">With Export Experience</td>
            @else
                <td class="field" colspan="3">Without Export Experience</td>
            @endif
        </tr>
        @if ($exhibitor->industry_rep === 1)
            <tr>
                <td class="label">Countries Exporting To (Top 3):</td>
                <td class="field" colspan="3">{{ $industry_rep_countries ?? '—' }}</td>
            </tr>
        @endif
        <tr>
            <td class="label">Specific Products/Services to be Promoted:</td>
            <td class="field" colspan="3">{{ $exhibitor->product_promoted ?? '—' }}</td>
        </tr>
        <tr>
            <td class="label">Supplier/Exhibitor Profile:</td>
            <td class="field" colspan="3">{{ $prod_category ?? '—' }}</td>
        </tr>
        <tr>
            <td colspan="4" class="label">
               Sustainable Development Goals (SDG) Alignment
            </td>
        </tr>
        <tr>
            <td class="field" colspan="4">
                <ul style="color: black;">
                    @foreach ($on_sdg as $sdg)
                        <li>{{ $sdg }}</li>
                    @endforeach
                </ul>
            </td>
        </tr>
        {{-- <tr>
            <td colspan="4" class="label">
                On Production Process
            </td>
        </tr> --}}
        {{-- <tr>
            <td class="field" colspan="4">
                <ul style="color: black;">
                    @foreach ($on_production_process as $process)
                        <li>{{ $process }}</li>
                    @endforeach
                </ul>
            </td>
        </tr> --}}
    </table>

    <!-- Participation Package Details -->
    @if (!empty($cart_items))
        <table class="detail" style="margin: 0px; border: none">
            <tr>
                <td colspan="4" style="border: none; text-align: center">
                    <h2>Participation Package Details</h2>
                </td>
            </tr>
        </table>

        <table class="detail" style="margin-top: 0px; border: none">
            <tr>
                <td class="label" style="width: 25%">Participation Type</td>
                <td class="field" colspan="3">
                    {{ $attendance_info->participation_type == 1 ? 'Individual' : ($attendance_info->participation_type == 2 ? 'Group' : '') }}
                </td>

            </tr>
        </table>

        @foreach ($cart_items as $item)
            <table class="detail" style="margin-top: 0px; border: none">
                <tr>
                    <td class="label" style="width: 25%">Package Details</td>
                    <td class="field" colspan="3">{{ $item['space_name'] ?? 'N/A' }}</td>
                </tr>
                <tr>
                    <td class="label">Booth Size</td>
                    <td class="field" colspan="3">{{ $item['booth_size_name'] ?? 'N/A' }} x
                        {{ $item['booth_qty'] }} </td>
                </tr>
                <tr>
                    <td class="label">Participation Fee</td>
                    <td class="field" colspan="3">
                        {{ $item['currency'] ?? '' }} {{ number_format($item['total_participation'] ?? 0, 2) }}
                    </td>
                </tr>
                <tr>
                    <td class="label">Total Amount</td>
                    <td class="field" colspan="3">
                        {{ $item['currency'] ?? '' }} {{ number_format($item['total_amount_due'] ?? 0, 2) }}
                    </td>
                </tr>
                <tr>
                    <td class="label">Discount </td>
                    <td class="field" colspan="3">
                        {{ $item['currency'] ?? '' }} {{ number_format($item['discount'] ?? '—', 2) }}
                    </td>
                </tr>
                <tr>
                    <td class="label" style="width: 25%">Discount Description</td>
                    <td class="field" colspan="3">{{ $item['discount_remarks'] ?? '—' }}</td>
                </tr>
                <tr>
                    <td class="label">Space Guidelines</td>
                    <td class="field" colspan="3">
                        @if (!empty($item['booth_details']))
                            {!! str_replace('<h5', '<h5 style="font-size:10px"', $item['booth_details']) !!}
                        @else
                            N/A
                        @endif
                    </td>
                </tr>
            </table>
        @endforeach

        {{-- Grand Total Table --}}
        @php
            $grandTotal = collect($cart_items)->sum('total_amount_due');
            $currency = $cart_items[0]['currency'] ?? '';
        @endphp
        <table class="detail" style="margin-top: 0px; border-top: 1px solid #000;">
            <tr>
                <td class="label" style="width: 25%"><strong>Total Amount</strong></td>
                <td class="field" colspan="3">
                    <strong>{{ $currency }} {{ number_format($grandTotal, 2) }}</strong>
                </td>
            </tr>
        </table>
    @else
        <p>No participation package details available.</p>
    @endif

    <!-- Additional Fees, Discounts, and Total Amount Due -->
    <table class="detail" style="margin: 0px; border: none">
        <tr>
            <td colspan="4" style="text-align: center; border: none;">
                <h2>Additional Fees, Discounts, and Total Amount Due</h2>
            </td>
        </tr>

        {{-- 🔸 Loop through Add-Ons --}}
        @if (!empty($addon_items))
            @foreach ($addon_items as $addon)
                <tr>
                    <td class="label" style="width: 25%">
                        ADD-ON: {{ $addon['qty'] }} × {{ $addon['addon_name'] }}
                    </td>
                    <td class="field" colspan="3">
                        {{ $addon['currency'] }} {{ number_format($addon['qty'] * $addon['rate_cost'], 2) }}
                    </td>
                </tr>
            @endforeach
        @endif

        {{-- 🔸 Loop through Additional Fees  --}}
        @if (!empty($additional_fees_items))
            @foreach ($additional_fees_items as $afi)
                <tr>
                    <td class="label" style="width: 25%">
                        {{ $afi['remarks'] }}
                    </td>
                    <td class="field" colspan="3">
                        {{ $afi['currency'] }} {{ number_format($afi['amount'], 2) }}
                    </td>
                </tr>
            @endforeach
        @endif

        {{-- 🔸 Loop through Discounts --}}
        @if (!empty($discount_items))
            @foreach ($discount_items as $disc)
                <tr>
                    <td class="label" style="width: 25%">
                        {{ $disc['remarks'] }}
                    </td>
                    <td class="field" colspan="3">
                        {{ $disc['currency'] }} <span
                            style="color: red">-</span>{{ number_format($disc['amount'], 2) }}
                    </td>
                </tr>
            @endforeach
        @endif





        {{--  Mandatory Fee --}}
        {{-- @if (!empty($mandatory_fee))
            <tr>
                <td class="label" style="width: 25%">IFEXConnect Mandatory Fee</td>
                <td class="field" colspan="3">
                    {{ $mandatory_fee['currency'] ?? '' }} {{ number_format($mandatory_fee['price'] ?? 0, 2) }}
                </td>
            </tr>
        @endif --}}

        {{--  Grand Total --}}
        @php
            $cartTotal = collect($cart_items)->sum('total_amount_due');

            // Add-ons total
            $addonTotal = collect($addon_items)->sum(function ($a) {
                return $a['qty'] * $a['rate_cost'];
            });

            // Additional fees total
            $additionalFeesTotal = collect($additional_fees_items ?? [])->sum(function ($f) {
                return $f['amount'] ?? 0;
            });

            // Discounts total
            $discountTotal = collect($discount_items ?? [])->sum(function ($d) {
                return $d['amount'] ?? 0;
            });

            // GRAND TOTAL = cart + add-ons + additional fees − discounts
            $grandTotal = $cartTotal + $addonTotal + $additionalFeesTotal - $discountTotal;

            // Pick currency from cart → add-ons → additional fees → discounts
            $currency =
                $cart_items[0]['currency'] ??
                ($addon_items[0]['currency'] ??
                    ($additional_fees_items[0]['currency'] ?? ($discount_items[0]['currency'] ?? '')));
        @endphp


        <tr>
            <td class="label" style="font-weight:bold;" style="width: 25%">Estimated Total Amount Due</td>
            <td class="field" style=" font-weight:bold;" colspan="3">
                {{ $currency }} {{ number_format($grandTotal, 2) }}
            </td>
        </tr>
    </table>



    {{-- Uploaded Requirements --}}
    <table class="detail" style="margin: 0px; border: none;">
        <tr>
            <td colspan="2" style="text-align: center; border:none;">
                <h2>Uploaded Requirements</h2>
            </td>
        </tr>

        @if (optional($docs)->dti_sec)
            <tr>
                <td class="label">Copy of registration from DTI or SEC (with complete articles of incorporation):</td>
                <td class="field">
                    <a style="text-decoration: underline;"
                        href="{{ asset(str_replace('public/', 'storage/', $docs->dti_sec)) }}" target="_blank">
                        {{ asset(str_replace('public/', 'storage/', $docs->dti_sec)) }}
                    </a>
                </td>
            </tr>
        @endif

        @if (optional($docs)->bir)
            <tr>
                <td class="label">Copy of registration from BIR (Form 2303):</td>
                <td class="field">
                    <a style="text-decoration: underline;"
                        href="{{ asset(str_replace('public/', 'storage/', $docs->bir)) }}" target="_blank">
                        {{ asset(str_replace('public/', 'storage/', $docs->bir)) }}
                    </a>
                </td>
            </tr>
        @endif

        @if (optional($docs)->lto)
            <tr>
                <td class="label">Copy of valid license to operate (LTO):</td>
                <td class="field">
                    <a style="text-decoration: underline;"
                        href="{{ asset(str_replace('public/', 'storage/', $docs->lto)) }}" target="_blank">
                        {{ asset(str_replace('public/', 'storage/', $docs->lto)) }}
                    </a>
                </td>
            </tr>
        @endif

        @if (optional($docs)->cpr)
            <tr>
                <td class="label">Copy of valid certificate of product registration (CPR):</td>
                <td class="field">
                    <a style="text-decoration: underline;"
                        href="    {{ asset(str_replace('public/', 'storage/', $docs->cpr)) }}" target="_blank">
                        {{ asset(str_replace('public/', 'storage/', $docs->cpr)) }}
                    </a>
                </td>
            </tr>
        @endif

        @if (optional($docs)->other_food_certificate)
            <tr>
                <td class="label">Other food certifications (Organic, HALAL, Kosher, HACCP, GMP, ISO, etc):</td>
                <td class="field">
                    <a style="text-decoration: underline;"
                        href="{{ asset(str_replace('public/', 'storage/', $docs->other_food_certificate)) }}"
                        target="_blank">
                        {{ asset(str_replace('public/', 'storage/', $docs->other_food_certificate)) }}
                    </a>
                </td>
            </tr>
        @endif

        @if (optional($docs)->institutional_catalog)
            <tr>
                <td class="label">Institutional brochure/catalog (company profile, product photos, site map):</td>
                <td class="field">
                    <a style="text-decoration: underline;"
                        href="{{ env('APP_URL') }}{{ Storage::url($docs->institutional_catalog) }}"
                        target="_blank">
                        {{ env('APP_URL') }}{{ Storage::url($docs->institutional_catalog) }}
                    </a>
                </td>
            </tr>
        @endif

        @if (optional($docs)->business_certification)
            <tr>
                <td class="label">Business Certification:</td>
                <td class="field">
                    <a style="text-decoration: underline;"
                        href="{{ env('APP_URL') }}{{ Storage::url($docs->business_certification) }}"
                        target="_blank">
                        {{ env('APP_URL') }}{{ Storage::url($docs->business_certification) }}
                    </a>
                </td>
            </tr>
        @endif

        @if (optional($docs)->food_or_environmental_certification)
            <tr>
                <td class="label">Food/Environmental Certification:</td>
                <td class="field">
                    <a style="text-decoration: underline;"
                        href="{{ env('APP_URL') }}{{ Storage::url($docs->food_or_environmental_certification) }}"
                        target="_blank">
                        {{ env('APP_URL') }}{{ Storage::url($docs->food_or_environmental_certification) }}
                    </a>
                </td>
            </tr>
        @endif
    </table>


   
   
<table class="detail" style="margin: 3px 0px 0px 0px; border: none;">
    <tr>
        <td colspan="2" style="text-align: center; border:none;">
            <h2>AGREEMENTS & DECLARATIONS</h2>
          
        </td>
          
    </tr>

    <tr>
            <td class="label" colspan="2" style=" border:none; padding-bottom: 10px">
                By submitting this online application, the supplier/exhibitor digitally agreed to the following:
            </td>
</tr>
    @foreach($agreements as $agreement)
        <tr>
            <td class="label" colspan="2"  style="border:none; vertical-align: top;">
                <strong>
                    [{{ $agreement['agreed'] ? 'AGREED' : 'DISAGREED' }}]
                </strong> 
                {{ $agreement['checkbox_title'] }}
                @if($agreement['id'] == 4)
                    (Optional)
                @endif
            </td>
        </tr>
    @endforeach

      <tr>
        <td class="label" colspan="2" style="border:none; padding-top:10px; font-style: italic;">
            This application process is conducted in compliance with relevant Philippine laws and government issuances, including but not limited to 
            <a href="https://www.bsp.gov.ph/PaymentAndSettlement/RA8792.pdf" target="_blank" style="text-decoration: underline; color: #0000EE;">
                Republic Act No. 8792 (The Electronic Commerce Act of 2000)
            </a> 
            and 
            <a href="https://www.coa.gov.ph/wpfd_file/coa-circular-no-2021-006-september-6-2021/" target="_blank" style="text-decoration: underline; color: #0000EE;">
                Commission on Audit (COA) Circular No. 2021-006
            </a>.
        </td>
    </tr>
    <tr>
         <td class="label" colspan="2" style="border:none; padding-top: 5px; padding-bottom:7px; font-style: italic;">
                Note: This summary is based on the information provided by the supplier/exhibitor in their application form. For any discrepancies or classifications, please refer to the original application data.
            </td>
    </tr>
</table>

      




    <table style="width: 100%" class="header">
        <tr>
            <td style="text-align: center;">-- END --</td>
        </tr>
    </table>
</body>



</html>
