<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\RegistrationView;
use App\Models\RegistrationUploadedFile;
use PDF;
use Dompdf\Dompdf;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class PDFController extends Controller
{

    
    public function USePATForm()
    {

        ini_set('memory_limit', '2048M');
        set_time_limit(3000);

        $appSignData = 8;
        $appPhotoData = 6;

        $users = RegistrationView::where('termid', 209)
            // ->where('Choice1_Campus', 'obrero')
            // ->where('AppNo', '2024-0000007633')
            // ->where('isValidated', 1)
            // ->whereBetween('AppNo', ['2024-0000004363', '2024-0000007634'])
            ->orderBy('AppNo', 'asc')  
            ->limit(10)
            ->get();

        foreach ($users as $user) {
            if ($user->AppNo) {
                try {
                    $appSign = RegistrationUploadedFile::where('appNo', $user->AppNo)
                        ->where('documentID', $appSignData)
                        ->first();

                    $appPhoto = RegistrationUploadedFile::where('appNo', $user->AppNo)
                        ->where('documentID', $appPhotoData)
                        ->first();

                    $user->imgSign_base64 = $appSign ? $this->safeBase64Encode($appSign->fileData) : null;
                    $user->imgPhoto_base64 = $appPhoto ? $this->safeBase64Encode($appPhoto->fileData) : null;

                    $logoPath = public_path('images/usep2.png');
                    $footerPath = public_path('images/Footer-Form.png');
                    $logoBase64 = 'data:image/png;base64,' . base64_encode(file_get_contents($logoPath));
                    $footerBase64 = 'data:image/png;base64,' . base64_encode(file_get_contents($footerPath));

                    $data = [
                        'school' => 'University of Southeastern Philippines',
                        'address' => 'Davao City',
                        'title' => 'USePAT APPLICATION FORM',
                        'consent' => 'DATA PRIVACY CONSENT',
                        'users' => [$user],
                        'logo_base64' => $logoBase64,
                        'footer_Base64' => $footerBase64,
                    ];

                    $dompdf = PDF::loadView('PDFs.USePATForm', $data);
                    $dompdf->setPaper('Legal', 'portrait');

                    if (!empty($user->MiddleName)) {
                        $user->MiddleName = strtoupper(substr($user->MiddleName, 0, 1));
                    } else {
                        $user->MiddleName = '';
                    }

                    $user->LastName = strtoupper($user->LastName);
                    $user->FirstName = strtoupper($user->FirstName);

                    $fileName = $user->LastName . '_' . $user->FirstName . '_' . $user->MiddleName . '_11_USEP_2025_1_1.pdf';
                    
                    $downloadsPath = getenv('USERPROFILE') . '\\Downloads\\'; // For Windows

                    $filePath = $downloadsPath . $fileName;

                    file_put_contents($filePath, $dompdf->output());

                    // $filePath = '' . $fileName;
                    // Storage::put($filePath, $dompdf->output());

                    Log::info("PDF generated successfully for user: {$user->AppNo}");

                } catch (\Exception $e) {
                    Log::error("Failed to generate PDF for user: {$user->AppNo}. Error: " . $e->getMessage());
                }
            } else {
                Log::warning("User with ID: {$user->id} has no AppNo.");
            }
        }
        
        //For redirection back - for bulk downloads
        return redirect()->back()->with('status', 'PDFs generated successfully!');

        //For downloading of 1 user only
        // return $dompdf->download('USePAT_Form.pdf');

        //For Viewing of 1 user only
        // return $dompdf->stream('USePAT_Form.pdf', ['Attachment' => false]);
    }

    public function USePATFormv2()
    {
        ini_set('memory_limit', '2048M');
        set_time_limit(3000);

        $appSignData = 8;
        $appPhotoData = 6;

        $users = RegistrationView::where('termid', 209)
            // ->where('Choice1_Campus', 'obrero')
            ->where('AppNo', '2024-0000007633')
            // ->where('isValidated', 1)
            // ->whereBetween('AppNo', ['2024-0000004363', '2024-0000007634'])
            ->orderBy('AppNo', 'asc')  
            ->limit(5)
            ->get();

        foreach ($users as $user) {
            if ($user->AppNo) {
                try {
                    $appSign = RegistrationUploadedFile::where('appNo', $user->AppNo)
                        ->where('documentID', $appSignData)
                        ->first();

                    $appPhoto = RegistrationUploadedFile::where('appNo', $user->AppNo)
                        ->where('documentID', $appPhotoData)
                        ->first();

                    $user->imgSign_base64 = $appSign ? $this->safeBase64Encode($appSign->fileData) : null;
                    $user->imgPhoto_base64 = $appPhoto ? $this->safeBase64Encode($appPhoto->fileData) : null;

                    $logoPath = public_path('images/usep2.png');
                    $footerPath = public_path('images/Footer-Form.png');
                    $logoBase64 = 'data:image/png;base64,' . base64_encode(file_get_contents($logoPath));
                    $footerBase64 = 'data:image/png;base64,' . base64_encode(file_get_contents($footerPath));

                    $data = [
                        'school' => 'University of Southeastern Philippines',
                        'address' => 'Davao City',
                        'title' => 'USePAT APPLICATION FORM',
                        'consent' => 'DATA PRIVACY CONSENT',
                        'users' => [$user],
                        'logo_base64' => $logoBase64,
                        'footer_Base64' => $footerBase64,
                    ];

                    $html = view('PDFs.USePATForm', $data)->render();

                    $dompdf = new Dompdf();
                    $dompdf->loadHtml($html);
                    $dompdf->setPaper('Legal', 'portrait');
                    $dompdf->render();

                    if (!empty($user->MiddleName)) {
                        $user->MiddleName = strtoupper(substr($user->MiddleName, 0, 1));
                    } else {
                        $user->MiddleName = '';
                    }

                    $user->LastName = strtoupper($user->LastName);
                    $user->FirstName = strtoupper($user->FirstName);

                    $fileName = $user->LastName . '_' . $user->FirstName . '_' . $user->MiddleName . '_11_USEP_2025_1_1.pdf';
                    $filePath = 'pdfs/' . $fileName;

                    Storage::put($filePath, $dompdf->output());

                    Log::info("PDF generated successfully for user: {$user->AppNo}");

                } catch (\Exception $e) {
                    Log::error("Failed to generate PDF for user: {$user->AppNo}. Error: " . $e->getMessage());
                }
            } else {
                Log::warning("User with ID: {$user->id} has no AppNo.");
            }
        }
        
        // return redirect()->back()->with('status', 'PDFs generated successfully!');
        return $dompdf->stream('document.pdf', ['Attachment' => false]);
    }

    private function safeBase64Encode($fileData)
    {
        $image = @imagecreatefromstring($fileData);
        if ($image !== false) {
            ob_start();
            imagejpeg($image);
            $jpegData = ob_get_clean();
            imagedestroy($image);
            return 'data:image/jpeg;base64,' . base64_encode($jpegData);
        } else {
            return null;
        }
    }
    



}
