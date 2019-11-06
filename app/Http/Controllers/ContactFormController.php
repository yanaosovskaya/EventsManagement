<?php

namespace App\Http\Controllers;

use App\Http\Requests\ContactFormRequest;
use App\Mail\ContactFormMail;
use App\Models\User;
use Mail, Captcha;

/**
 * Class ContactFormController
 * @package App\Http\Controllers
 */
class ContactFormController extends Controller
{
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        $isCaptcha = setting('contact_form_captcha');
        return view('contact-form.create', compact('isCaptcha'));
    }

    /**
     * @param ContactFormRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(ContactFormRequest $request)
    {
        try {
            if (setting('contact_form_captcha') && Captcha::verify() !== true) {
                return redirect()->route('contact-form.create')->with('error', trans('contact-form.error_captcha'));
            }

            $recipients = json_decode(setting('contact_form_recipient_email_address'), true);
            if ($recipients === null) {
                $recipients = [env('ADMIN_MAIL')];
            }
            $users = User::whereIn('email', $recipients)->get();

            Mail::to($users)->send(new ContactFormMail($request));
            event(config('platform.event_contact_form_sent'), $request);
        } catch (\Exception $e) {
            return redirect()
                ->route('contact-form.create')
                ->with('error', is_numeric($e->getCode()) ? $e->getCode() : 500);
        }

        return redirect()->route('contact-form.create')->with('success', trans('contact-form.sent_successful'));
    }
}
