<?php

namespace Modules\Setting\Http\Controllers;

use App\Http\Controllers\Controller;
use Brian2694\Toastr\Facades\Toastr;
use Modules\Setting\Entities\EmailConfig;
use Modules\Setting\Http\Requests\MailRequest;

class MailController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:read_mail_setup')->only('index');
        $this->middleware('permission:create_mail_setup')->only(['store']);
        $this->middleware(['demo'])->only(['store']);
    }


    public function index()
    {
        return view('setting::mail.index', [
            'mail' => EmailConfig::first(),
        ]);
    }

    public function store(MailRequest $request)
    {

        if ($request->id) {
            $mail = EmailConfig::findOrFail($request->id);
        } else {
            $mail = new EmailConfig();
        }

        $mail['isinvoice']   = 1;
        $mail['isservice']   = 1;
        $mail['isquotation'] = 1;
        $mail->fill($request->all());
        $mail->save();

        Toastr::success('Mails added successfully :)', 'Success');
        return redirect()->route('mails.index')->with('success', 'Data updated successfully');
    }

}
