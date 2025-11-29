<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Contest;
use App\Models\Fundraising;
use App\Models\Report;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ContentActionController extends Controller
{
    /**
     * Générer un fichier ICS pour un événement
     */
    public function eventCalendar(Event $event)
    {
        return $this->generateICS(
            $event->title,
            $event->description,
            $event->start_date,
            $event->end_date,
            $event->venue_address ?? $event->venue_name ?? $event->venue_city,
            route('events.show', $event)
        );
    }

    /**
     * Générer un fichier ICS pour un concours
     */
    public function contestCalendar(Contest $contest)
    {
        return $this->generateICS(
            $contest->name,
            $contest->description,
            $contest->start_date,
            $contest->end_date,
            $contest->event->venue_address ?? $contest->event->venue_name ?? $contest->event->venue_city ?? null,
            route('contests.show', $contest)
        );
    }

    /**
     * Générer un fichier ICS pour une collecte de fonds
     */
    public function fundraisingCalendar(Fundraising $fundraising)
    {
        return $this->generateICS(
            $fundraising->name,
            $fundraising->description,
            $fundraising->start_date,
            $fundraising->end_date,
            $fundraising->event->venue_address ?? $fundraising->event->venue_name ?? $fundraising->event->venue_city ?? null,
            route('fundraisings.show', $fundraising)
        );
    }

    /**
     * Générer le contenu ICS
     */
    private function generateICS($title, $description, $startDate, $endDate, $location, $url)
    {
        $start = $startDate->format('Ymd\THis\Z');
        $end = $endDate->format('Ymd\THis\Z');
        $now = now()->format('Ymd\THis\Z');
        
        $description = strip_tags($description);
        $description = str_replace(["\r\n", "\r", "\n"], "\\n", $description);
        $description = substr($description, 0, 200); // Limiter la longueur
        
        $location = $location ? str_replace(["\r\n", "\r", "\n"], " ", $location) : '';
        
        $ics = "BEGIN:VCALENDAR\r\n";
        $ics .= "VERSION:2.0\r\n";
        $ics .= "PRODID:-//Tikehub//Event Calendar//FR\r\n";
        $ics .= "CALSCALE:GREGORIAN\r\n";
        $ics .= "METHOD:PUBLISH\r\n";
        $ics .= "BEGIN:VEVENT\r\n";
        $ics .= "UID:" . uniqid() . "@tikehub.com\r\n";
        $ics .= "DTSTAMP:" . $now . "\r\n";
        $ics .= "DTSTART:" . $start . "\r\n";
        $ics .= "DTEND:" . $end . "\r\n";
        $ics .= "SUMMARY:" . $this->escapeICS($title) . "\r\n";
        $ics .= "DESCRIPTION:" . $this->escapeICS($description) . "\\n\\n" . $url . "\r\n";
        if ($location) {
            $ics .= "LOCATION:" . $this->escapeICS($location) . "\r\n";
        }
        $ics .= "URL:" . $url . "\r\n";
        $ics .= "END:VEVENT\r\n";
        $ics .= "END:VCALENDAR\r\n";

        $filename = str_replace([' ', '/'], ['_', '-'], $title) . '.ics';
        
        return response($ics, 200, [
            'Content-Type' => 'text/calendar; charset=utf-8',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ]);
    }

    /**
     * Échapper les caractères spéciaux pour ICS
     */
    private function escapeICS($text)
    {
        $text = str_replace('\\', '\\\\', $text);
        $text = str_replace(',', '\\,', $text);
        $text = str_replace(';', '\\;', $text);
        $text = str_replace("\n", '\\n', $text);
        return $text;
    }

    /**
     * Signaler un événement
     */
    public function reportEvent(Request $request, Event $event)
    {
        $validated = $request->validate([
            'reason' => 'required|string|in:inappropriate_content,false_information,spam,scam,copyright,other',
            'message' => 'required|string|max:1000',
        ]);

        Report::create([
            'reportable_type' => Event::class,
            'reportable_id' => $event->id,
            'reporter_id' => auth()->id(),
            'reason' => $validated['reason'],
            'message' => $validated['message'],
            'status' => 'pending',
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Votre signalement a été enregistré. Nous allons examiner ce contenu.'
        ]);
    }

    /**
     * Signaler un concours
     */
    public function reportContest(Request $request, Contest $contest)
    {
        $validated = $request->validate([
            'reason' => 'required|string|in:inappropriate_content,false_information,spam,scam,copyright,other',
            'message' => 'required|string|max:1000',
        ]);

        Report::create([
            'reportable_type' => Contest::class,
            'reportable_id' => $contest->id,
            'reporter_id' => auth()->id(),
            'reason' => $validated['reason'],
            'message' => $validated['message'],
            'status' => 'pending',
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Votre signalement a été enregistré. Nous allons examiner ce contenu.'
        ]);
    }

    /**
     * Signaler une collecte de fonds
     */
    public function reportFundraising(Request $request, Fundraising $fundraising)
    {
        $validated = $request->validate([
            'reason' => 'required|string|in:inappropriate_content,false_information,spam,scam,copyright,other',
            'message' => 'required|string|max:1000',
        ]);

        Report::create([
            'reportable_type' => Fundraising::class,
            'reportable_id' => $fundraising->id,
            'reporter_id' => auth()->id(),
            'reason' => $validated['reason'],
            'message' => $validated['message'],
            'status' => 'pending',
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Votre signalement a été enregistré. Nous allons examiner ce contenu.'
        ]);
    }
}
