<?php

namespace App\Traits;

use Illuminate\Support\Facades\Storage;

trait ReportLayoutTrait
{
    /**
     * Set the layout for the report data table.
     *
     * @return string
     */
    private function printLayout()
    {
        return 'function(win) {
                            $(win.document.body).find(\'h1\').remove();
                            $(win.document.body).prepend(
                                `<div style="display: flex; justify-content: space-between;margin-bottom: 1rem;">
                                    <div style="font-size: 13px;">
                                    <strong style="color: #000;text-transform: uppercase;font-size: 17px;">Four Nine Gold and Jewelery Company</strong><br>
                                    <div style="color: #000;font-size: 16px;">Mahmoud Saeed Mall - third-floor office no</div>
                                    <span style="color: #000; font-weight: 700">Tax number:&nbsp;</span>210840985100003 <br>
                                    <span style="color: #000; font-weight: 700">Tel:&nbsp;</span>0535001616<br>
                                    <span style="color: #000; font-weight: 700">Fax:&nbsp;</span>0126445678<br>
                                    <span style="color: #000; font-weight: 700">Commercial Reg:&nbsp;</span>4030404864<br>
                                    </div>
                                    <div style="text-align: right;font-size: 16px;">
                                    <div>
                                        <strong style="color: #000;text-transform: uppercase;font-size: 19px;">شركة فور ناين للذهب والمجوهرات</strong><br>
                                        <div style="color: #000;font-size: 17px;">محمود سعيد مول - الدور الثالث مكتب رقم</div>
                                        <span style="color: #000; font-weight: 700">الرقم الضريبي:&nbsp;</span>٢١٠٨٤٠٩٨٥١٠٠٠٠٣ <br>
                                        <span style="color: #000; font-weight: 700">تليفون :&nbsp;</span>٠٥٣٥٠٠١٦١٦<br>
                                        <span style="color: #000; font-weight: 700">فاكس:&nbsp;</span>٠١٢٦٤٤٥٦٧٨<br>
                                        <span style="color: #000; font-weight: 700">السجل التجاري:&nbsp;</span>٤٠٣٠٤٠٤٨٦٤<br>
                                    </div>
                                    </div>
                                </div>
                                <hr style="border-width: 2px; border-color: #000;">`
                            );
                        }';
    }

    private function pdfLayout($footer = false)
    {
        return 'function(doc) {
                                ' . $this->pdfDesign() . '
                                ' . $this->pdfCustomizeTableHeader($footer) . '
                            }';
    }

    //pdf table style
    private function pdfCustomizeTableHeader($footer = false) : string
    {
        if ($footer) {
            $footer = '//change footer css
            doc.content[5].table.body[doc.content[5].table.body.length - 1].forEach(function(cell) {
                cell.alignment = \'right\';
                cell.bold = true;
                cell.color = \'#000\';
            });';
        }
        else {
            $footer = '';
        }

        return '
            //row width
            doc.content[5].table.widths[2] = 100;

            //header colum css
            doc.content[5].table.body[0][0].alignment = \'left\';
            doc.content[5].table.body[0][1].alignment = \'left\';
            doc.content[5].table.body[0][2].alignment = \'left\';
         ' . $footer;
    }

    private function pdfDesign() : string
    {
        return '
        //pdf margin
        doc.pageMargins = [15, 5, 15, 10];
        //for Arabic supported font
        doc.defaultStyle.font = "Arabic";

       //admin name top of page left
        doc.content.splice(0, 0, {
        //left, top, right, bottom
        margin: [0, 0, 0, 10],
        alignment: \'center\',
        text: [
        { text: \'' . app_setting()->title . '\', fontSize: 15, bold: true },
        ]
        });


        //pdf header add logo
        doc.content.splice(1, 0, {
            margin: [0, 0, 10, 0],
            alignment: \'center\',
            width: 64,
            image: \'data:image/png;base64,' . $this->getLogo() . '\'
        });

        //pdf header add address
        doc.content.splice(2, 0, {
            //left, top, right, bottom
            margin: [0, 0, 0, 10],
            alignment: \'center\',
            text: [
                { text: \'' . app_setting()->address . '\', fontSize: 8, bold: false },
                ]
            });

        //pdf date range
        var date_range = $(\'#sale_date\').val();
        if(date_range == \'\'){
            date_range = \'All\';
        }
        doc.content.splice(4, 0, {

            });

        doc.content[5].table.widths = Array(doc.content[5].table.body[0].length + 1).join(\'*\').split(\'\');

        //change table font size && table fill color
        doc.content[5].table.body.forEach(function(row) {
            row.forEach(function(cell) {
                cell.fontSize = 8;
                cell.fillColor = \'#fff\';
            });
        });

        //change header text color
        doc.content[5].table.body[0].forEach(function(cell) {
            cell.color = \'#000\';
            cell.fillColor = \'#FF9800\';
        });

        var objLayout = {};
        objLayout[\'hLineWidth\'] = function(i) { return .5; };
        objLayout[\'vLineWidth\'] = function(i) { return .5; };
        objLayout[\'hLineColor\'] = function(i) { return \'#dee2e6\'; };
        objLayout[\'vLineColor\'] = function(i) { return \'#dee2e6\'; };
        objLayout[\'paddingLeft\'] = function(i) { return 4; };
        objLayout[\'paddingRight\'] = function(i) { return 4; };
        doc.content[5].layout = objLayout;';
    }

    private function getLogo()
    {
        if (app_setting()->logo_path && Storage::exists('public/' . app_setting()->logo_path)) {
            return base64_encode(file_get_contents(storage_path('app/public/' . app_setting()->logo_path)));
        }
        return base64_encode(file_get_contents(public_path('backend/assets/img/logo.jpg')));

    }
}
