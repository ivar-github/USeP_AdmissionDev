<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Application Form</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            font-size: 9px;
        }
        .container {
            /* padding: 1px; */
            /* page-break-after: always; */
        }
        .header {
            display: flex;
            flex-direction: column; /* Align elements vertically */
            justify-content: center; /* Center elements vertically */
            align-items: center; /* Center elements horizontally */
            text-align: center; /* Center the text content */
        }
        .header img {
            width: 150px;  
        }
        .header .photo {
            width: 1.5in;
            height: 2in;
            margin-bottom: 50px;
            border: 1px solid #000;
        }
        .header h1, h2, h3, h4 {
            margin : 5px;
        }
        .section-title {
            font-size: 20px;
            border-bottom: 1px solid #000;
        }
        .section-content {
            /* margin-top: 10px; */
        }
        table {
            width: 100%;  
            border-collapse: collapse;  
        }
        th, td {
            padding: 2px;  
            text-align: left;  
        }
        th {
            background-color: #f2f2f2; 
        }
        .signature-container {   
            /* margin-top: 20px; */
        }
        .signature-line {
            border-bottom: 1px solid #000;
            width: 200px;
            margin-bottom: 5px;
        }

        .footer {
            position: fixed;
            bottom: 0;
            width: 100%;
            background-color: #f1f1f1;  
            text-align: center;
            padding: 0px;
            margin: 0px;
        }
        
        .footer-photo {
            height: auto; 
        }
    </style>
</head>
<body>
    @foreach($users as $user)

    <div class="container">        <table>
        <tbody>
            <tr>
                <td >
                </td>
                <td colspan="4" style="text-align: center; border: 1px;  vertical-align: top; ">
                    <div>
                        <img src="{{ $logo_base64 }}" alt="Logo"  style="width:150px">
                        <h3>{{ $school }}</h3>
                        <h3>{{ $address }}</h3>
                        <h2>{{ $title }}</h3>
                    </div>
                </td>
                <td style="text-align: center;">
                    <img src="{{ $user->imgPhoto_base64}}" alt="Logo" style="width:90px; border:2px solid #000;">
                </td>
            </tr>
            <tr>
                <td colspan="6" style="height: 5px;"></td>
            </tr>
            <tr >
            </tr>
            <tr >
                <td colspan="5" style="text-align: center;">Student Type: &nbsp; [ {{$user->ForeignLastName ? ' / ' : ' '}} ]Local  &nbsp; [  {{$user->ForeignLastName ? ' ' : ' /  '}}  ]Foreign </td>
                <td  colspan="1"  style="text-align: right;"><b>Application Number:</b> {{$user->AppNo}}</td>
            </tr>
            <tr style="border: 1px solid #000;">
                <td colspan="6" style="text-align: center;">PROGRAM APPLIED FOR: &nbsp; &nbsp; [ / ]UnderGraduate &nbsp;&nbsp; ( [ {{$user->ApplyTypeID==1 ? ' / ' : ' '}} ]Senior High &nbsp;&nbsp; [ {{$user->ApplyTypeID==1 ? ' ' : ' / '}} ]Transferee )&nbsp;&nbsp;  [ ] ETEEAP &nbsp;  [ ] Advanced Studies &nbsp;  [ ]School of Medicines &nbsp;  [ ]School of Law</td>
            </tr>
            <tr>
                <td colspan="3" style="font-weight: bold; text-align: center; font-size: 9px; border: 1px solid #000;">PERSONAL INFORMATION (for Local & Foreign Applicants)</td>
                <td colspan="3" style="font-weight: bold; text-align: center; font-size: 9px; border: 1px solid #000;">(for Foreign Applicants ONLY)</td>
            </tr>
            <tr>
                <td colspan="3" style="border: 1px solid #000; text-align: center; font-size: 9px;">
                    <table>
                        <tr>
                            <td colspan="4"><b>Last Name:</b></b> {{$user->LastName}}</td>
                        </tr>
                        <tr>
                            <td colspan="4"><b>First Name:</b> {{$user->FirstName}}</td>
                        </tr>
                        <tr>
                            <td><b>Middle Name:</b> {{$user->MiddleName}}</td>
                            <td colspan="3"><b>Suffix:</b> {{$user->ExtName}} </td>>
                        </tr>
                        <tr>
                            <td><b>Date of Birth:</b> {{$user->DateOfBirth}}</td>
                            <td colspan="3"><b>Place of Birth:</b> {{$user->PlaceOfBirth}} </td>>
                        </tr>
                        <tr>
                            <td><b>Gender:</b> {{$user->Gender}}</td>
                            <td colspan="3"><b>Status:</b> {{$user->CivStatus}}</td>>
                        </tr>
                        <tr>
                            <td><b>Citizenship:</b> {{$user->Nationality}}</td>
                            <td colspan="3"><b>Religion:</b>  {{$user->Religion}}</td>>
                        </tr>
                        <tr>
                            <td colspan="4"><b>Present Address:</b> {{$user->Res_Street}} {{$user->Res_Barangay}}  {{$user->Res_TownCity}} </td>
                        </tr>
                        <tr>
                            <td colspan="4"><b>Permanent Address:</b> {{$user->Perm_Street}} {{$user->Perm_Barangay}}  {{$user->Perm_TownCity}}  </td>
                        </tr>
                        <tr>
                            <td colspan="4"><b>Zip Code:</b> {{$user->Res_ZipCode}}</td>
                        </tr>
                        <tr>
                            <td colspan="4"><b>Email Adress:</b> {{$user->Email}}</td>
                        </tr>
                        <tr>
                            <td colspan="4"><b>Contact Number:</b> {{$user->TelNo}}</td>
                        </tr>
                        <tr>
                            <td colspan="4"><b>Person with Disabiliy:</b> ( {{$user->HasSpecialNeed ? ' / ' : ' '}} )Yes  ({{$user->HasSpecialNeed ? ' ' : ' / '}} )No</td>
                        </tr>
                        <tr>
                            <td colspan="4"><b>If Yes, Indicate Disability:</b> {{$user->HasSpecialNeed ? $user->Disability : ' '}} </td>
                        </tr>
                        <tr>
                            <td colspan="4"><b>Member of Indigenous People:</b> ( {{$user->IsMemberOfIP ? ' / ' : ' '}} )Yes  ( {{$user->IsMemberOfIP ? ' ' : ' / '}} )No</td>
                        </tr>
                        <tr>
                            <td colspan="4"><b>If Yes, Indicate Tribe:</b> {{$user->IsMemberOfIP ? $user->tribeName : ' '}}  </td>
                        </tr>
                        <tr>
                            <td colspan="4"><b>Solo Parent:</b> ( {{$user->IsMemberOfIP ?  ' / ' : ' '}} )Yes  ( {{$user->IsMemberOfIP ?  ' ' : ' / '}} )No</td>
                        </tr>
                    </table>
                </td>
                <td colspan="3" style="border-right: 1px solid #000; text-align: center; font-size: 9px; ">
                    <table style="  align-items:start;">
                        <tr>
                            <td colspan="4" style=" #000; font-weight: bold;">Name (as written in your native lanuage alphabet)</td>
                        </tr>
                        <tr>
                            <td colspan="4" style=" #000;"><b>Last Name:</b> {{$user->ForeignLastName}}</td>
                        </tr>
                        <tr>
                            <td colspan="4" style=" #000;"><b>First Name:</b> {{$user->ForeignFirstName}}</td>
                        </tr>
                        <tr>
                            <td colspan="4" style=" #000;"><b>Middle Name:</b> {{$user->ForeignMiddleName}}</td>
                        </tr>
                        <tr>
                            <td colspan="4" style=" #000;"><b>Suffix:</b> {{$user->ForeignSuffix}}</td>
                        </tr>
                        <tr>
                            <td colspan="4" style=" #000;"><b>Other Names:</b> {{$user->ForeignOtherName}}</td>
                        </tr>
                        <tr>
                            <td colspan="4" style=" #000; height: 10px;"></td>
                        </tr>
                        <tr>
                            <td colspan="4" style=" #000; font-weight: bold; border-top: 1px solid #000;"><b>Passport Details</td>
                        </tr>
                        <tr>
                            <td colspan="4" style=" #000;"><b>Passport Number:</b> {{$user->PassportNumber}}</td>
                        </tr>
                        <tr>
                            <td colspan="4" style=" #000;"><b>Place of Issue:</b> {{$user->PassportPlaceIssued}}</td>
                        </tr>
                        <tr>
                            <td colspan="4" style=" #000;"><b>Date Issued:</b> {{$user->PassportDateIssued}}</td>
                        </tr>
                        <tr>
                            <td colspan="4" style=" #000;"><b>Expiry Date:</b> {{$user->PassportExpirydate}}</td>
                        </tr>
                        <tr>
                            <td colspan="4" style=" #000; height: 30px;"></td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr>
                <td colspan="3" style="border: 1px solid #000; text-align: center; font-size: 9px; ">
                    <span style="font-weight: bold;">FAMILY BACKGROUND</span> 
                </td>
                <td colspan="3" style="border: 1px solid #000; text-align: center; font-size: 9px; ">
                    <span ><b>SCHOLASTIC BACKGROUND</b> (for Undergrauate Local/Foreign Applicants ONLY)</span> 
                </td>
            </tr>
            <tr>
                <td  colspan="3"  style="border: 1px solid #000; text-align: center; font-size: 9px; ">
                    <table style="border: 1px solid #000;  align-items:start;">
                        <tr>
                            <td style="border: 1px solid #000;"> </td>
                            <td style="border: 1px solid #000;"><b>Father</b></td>
                            <td style="border: 1px solid #000;"><b>Mother</b></td>
                        </tr>
                        <tr>
                            <td style="border: 1px solid #000;"><b>Last Name:</b></td>
                            <td style="border: 1px solid #000;">{{$user->FatherLastName}}</td>
                            <td style="border: 1px solid #000;">{{$user->MotherLastName}}</td>
                        </tr>
                        <tr>
                            <td style="border: 1px solid #000;"><b>First Name:</b></td>
                            <td style="border: 1px solid #000;">{{$user->FatherFirstName}}</td>
                            <td style="border: 1px solid #000;">{{$user->MotherFirstName}}</td>
                        </tr>
                        <tr>
                            <td style="border: 1px solid #000;"><b>Middle Name:</b></td>
                            <td style="border: 1px solid #000;">{{$user->FatherMidName}}</td>
                            <td style="border: 1px solid #000;">{{$user->MotherMidName}}</td>
                        </tr>
                        <tr>
                            <td style="border: 1px solid #000;"><b>Citizenship:</b></td>
                            <td style="border: 1px solid #000;">{{$user->FatherCitizenship}}</td>
                            <td style="border: 1px solid #000;">{{$user->MotherCitizenship}}</td>
                        </tr>
                        <tr>
                            <td style="border: 1px solid #000;"><b>Occupation:</b></td>
                            <td style="border: 1px solid #000;">{{$user->Father_Occupation}}</td>
                            <td style="border: 1px solid #000;">{{$user->Mother_Occupation}}</td>
                        </tr>
                        <tr>
                            <td style="border: 1px solid #000;"><b>Annual Income:</b></td>
                            <td style="border: 1px solid #000;">{{$user->FatherIncomeFrom}}-{{$user->FatherIncomeTo}}</td>
                            <td style="border: 1px solid #000;">{{$user->MotherIncomeFrom}}-{{$user->MotherIncomeTo}}</td>
                        </tr>
                        <tr>
                            <td style="border: 1px solid #000;"><b>Living/Deceased?</b></td>
                            <td style="border: 1px solid #000;">{{$user->FatherType }}</td>
                            <td style="border: 1px solid #000;">{{$user->MotherType }}</td>
                        </tr>
                    </table> 
                </td>
                <td   colspan="3" style="border: 1px solid #000;  font-size: 9px;  ">
                    <span><b>Graduate of K-12 curriculum? </b> [ {{$user->IsNotK12Graduate ? ' ' : ' / ' }} ]Yes  [ {{$user->IsNotK12Graduate ? ' / ' : ' ' }}]No</span></br>
                    <span>If yes, </br>
                        <b>Senior High Track:</b> {{$user->track_name ? $user->track_name : ''}} </br> 
                        <b>Strand:</b> {{$user->strand_name ? $user->strand_name : ''}}</span></br><br>
                    <span><b>Learner Reference Number (LRN):</b> {{$user->LRN}}</span></br></br>   
                    
                    <table style="border: 1px solid #000;  align-items:start;">
                        <tr>
                            <td style="border: 1px solid #000;"><b>Level</b></td>
                            <td colspan="3" style="border: 1px solid #000;">Grade Point Average (GPA) /  General Average</td>
                        </tr>
                        <tr>
                            <td style="border: 1px solid #000;"><b>Grade 11</b></td>
                            <td colspan="3" style="border: 1px solid #000;">{{$user->Grade_11 ? $user->Grade_11 : ''}}</td>
                        </tr>
                        <tr>
                            <td style="border: 1px solid #000;"><b>College (for transferees)</b></td>
                            <td colspan="3" style="border: 1px solid #000;">{{$user->College_GPA ? $user->College_GPA : ''}}</td>
                        </tr>
                    </table> 
                </td>
            </tr>
            
            <tr>
                <td  colspan="6"  style="border: 1px solid #000; text-align: center; font-size: 9px; ">
                    <span style="font-weight: bold;">EDUCATIONAL BACKGROUND</span> 
                    
                    <table style="border: 1px solid #000;  align-items:start;">
                        <tr>
                            <td style="border: 1px solid #000;"><b>Level</b> </td>
                            <td style="border: 1px solid #000;"><b>Name of School</b></td>
                            <td style="border: 1px solid #000;"><b>Type of School</b> (Private or Public)</td>
                            <td style="border: 1px solid #000;"><b>Year Graduated</b></td>
                            <td style="border: 1px solid #000;"><b>Degree Program</b></br> (if applicable)</td>
                            <td style="border: 1px solid #000;"><b>Address</b></td>
                        </tr>
                        <tr>
                            <td style="border: 1px solid #000;"><b>Elementary</b></td>
                            <td style="border: 1px solid #000;">{{$user->Elem_School}}</td>
                            <td style="border: 1px solid #000;">{{$user->Elem_SchoolType}}</td>
                            <td style="border: 1px solid #000;">{{$user->Elem_InclDates}}</td>
                            <td style="border: 1px solid #000;"></td>
                            <td style="border: 1px solid #000;">{{$user->Elem_Address}}</td>
                        </tr>
                        <tr>
                            <td style="border: 1px solid #000;"><b>Jr. High School</b> </br>(High School for OLD Curriculum)</td>
                            <td style="border: 1px solid #000;">{{$user->HS_School}}</td>
                            <td style="border: 1px solid #000;">{{$user->HSchoolType}}</td>
                            <td style="border: 1px solid #000;">{{$user->HS_InclDates}}</td>
                            <td style="border: 1px solid #000;"></td>
                            <td style="border: 1px solid #000;">{{$user->HS_Address}}</td>
                        </tr>
                        <tr>
                            <td style="border: 1px solid #000;"><b>Sr. High School </b></br>(if applicable)</td>
                            <td style="border: 1px solid #000;">{{$user->College_School}}</td>
                            <td style="border: 1px solid #000;">{{$user->SrHSchoolType}}</td>
                            <td style="border: 1px solid #000;">{{$user->College_InclDates}}</td>
                            <td style="border: 1px solid #000;"></td>
                            <td style="border: 1px solid #000;">{{$user->College_Address}}</td>
                        </tr>
                        <tr>
                            <td style="border: 1px solid #000;"><b>Vocational / Trade Course</b> </br>(if  applicable)</td>
                            <td style="border: 1px solid #000;">{{$user->Vocational}}</td>
                            <td style="border: 1px solid #000;"></td>
                            <td style="border: 1px solid #000;">{{$user->Vocational_InclDates}}</td>
                            <td style="border: 1px solid #000;">{{$user->Vocational_Degree}}</td>
                            <td style="border: 1px solid #000;">{{$user->Vocational_Address}}</td>
                        </tr>
                        <tr>
                            <td style="border: 1px solid #000;"><b>Bachelor's Degree</b> </br>(if applicable)</td>
                            <td style="border: 1px solid #000;">{{$user->BachelorsDegree_School}}</td>
                            <td style="border: 1px solid #000;">{{$user->BachelorsDegree_SchoolType}}</td>
                            <td style="border: 1px solid #000;">{{$user->BachelorsDegree_InclDates}}</td>
                            <td style="border: 1px solid #000;">{{$user->BachelorsDegree_Name}}</td>
                            <td style="border: 1px solid #000;">{{$user->BachelorsDegree_Address}}</td>
                        </tr>
                        <tr>
                            <td style="border: 1px solid #000;"><b>Graduate Degree</b> </br>(if applicable)</td>
                            <td style="border: 1px solid #000;">{{$user->GraduateDegree_School}}</td>
                            <td style="border: 1px solid #000;">{{$user->GraduateDegree_SchoolType}}</td>
                            <td style="border: 1px solid #000;">{{$user->GraduateDegree_InclDates}}</td>
                            <td style="border: 1px solid #000;">{{$user->GraduateDegree_Name}}</td>
                            <td style="border: 1px solid #000;">{{$user->GraduateDegree_Address}}</td>
                        </tr>
                    </table> 
                </td>
            </tr>
            <tr>
                <td colspan="3" style="border: 1px solid #000; text-align: center; font-size: 9px; ">
                    <span style="font-weight: bold;">COURSE/PROGRAM INFORMATION</span></br>
                    <span>Note: Identify THREE (3) preferences for Undergraduate Applicants,</span></br>
                    <span>ONE (1) for ETEEAP, Advance Studies, School of Medicine, School of Law Applicants</span> 
                </td>
                <td colspan="3" style="border: 1px solid #000; text-align: center; font-size: 9px; ">
                    <span style="font-weight: bold;">PERSON TO CONTACT IN CASE OF EMERGENCY</span> 
                </td>
            </tr>
            <tr>
                <td  colspan="3"  style="border: 1px solid #000;  font-size: 9px; ">

                    <table style="border: 1px solid #000;  align-items:start;">
                        <tr>
                            <td  style="border: 1px solid #000;"> </td>
                            <td  style="border: 1px solid #000;"><b>Preference #1</b></td>
                            <td  style="border: 1px solid #000;"><b>Preference #2</b></td>
                            <td  style="border: 1px solid #000;"><b>Preference #3</b></td>
                        </tr>
                        <tr>
                            <td  style="border: 1px solid #000;"><b>Progran</b></td>
                            <td  style="border: 1px solid #000;">{{$user->Choice1_Program}}</td>
                            <td  style="border: 1px solid #000;">{{$user->Choice2_Program}}</td>
                            <td  style="border: 1px solid #000;">{{$user->Choice3_Program}}</td>
                        </tr>
                        <tr>
                            <td  style="border: 1px solid #000;"><b>Major</b></td>
                            <td  style="border: 1px solid #000;">{{$user->Choice1_Major}}</td>
                            <td  style="border: 1px solid #000;">{{$user->Choice2_Major}}</td>
                            <td  style="border: 1px solid #000;">{{$user->Choice3_Major}}</td>
                        </tr>
                        <tr>
                            <td  style="border: 1px solid #000;"><b>Campus</b></td>
                            <td  style="border: 1px solid #000;">{{$user->Choice1_Campus}}</td>
                            <td  style="border: 1px solid #000;">{{$user->Choice2_Campus}}</td>
                            <td  style="border: 1px solid #000;">{{$user->Choice3_Campus}}</td>
                        </tr>
                    </table> 
                    <span style="text-align: left; font-size: 9px; "><b>Academic Year Applied for:</b>  {{$user->AcademicYear}} - {{$user->SchoolTerm}} </span></br>
                    <span style="text-align: left; font-size: 9px; "><b>Selected Testing Center (for Undergraduate):</b>   {{$user->testCenter}} </span> 
                </td>
                <td   colspan="3" style="border: 1px solid #000;  font-size: 9px; ">
                    <span style="text-align: left; font-size: 9px; "><b>Name: </b> {{$user->Emergency_Contact}}</span></br>
                    <span style="text-align: left; font-size: 9px; "><b>Relationship: </b>{{$user->Emergency_Relation}}</span></br> 
                    <span style="text-align: left; font-size: 9px; "><b>Address: </b> {{$user->Emergency_Address}}</span></br> 
                    <span style="text-align: left; font-size: 9px; "><b>Contact Number: </b> {{$user->Emergency_TelNo}}</span> 
                </td>
            </tr>
            <tr>
                <td colspan="6" style="text-align: left;">
                    
                    <p style="font-size:10px;">I have read the University of Southeastern Philippines’ Data Privacy Statement and hereby allow the University to collect, use, process and store my personal information through its
                        official channels for legitimate purposes. I affirm my fundamental right to privacy and my constitutional data privacy rights as stated in the Republic Act No. 10173 of the Philippines.
                        This consent is hereby given on the guarantee that these rights shall be upheld at all times.
                    </p>
                    <p style="font-size:10px;">By signing below, I hereby affirm that the information provided in this form, including pertinent documents attached, is accurate and truthful to the best of my knowledge. I acknowledge
                        that, should any of the information be found to be false or inaccurate, the University reserves the right to deny my admission and pursue any appropriate legal actions, whether
                        administrative, civil, or criminal.
                    </p>
                
                </td>
            </tr>


            <tr>
                <td colspan="4" style="text-align: center;"> </td>
                <td colspan="2" style="text-align: center;">
                    <div class="signature-container">
                        <div><img  src="{{ $user->imgSign_base64 }}" alt="Image" style="height:50px;"></div>
                        <div>{{$user->LastName}}, {{$user->FirstName}}, {{$user->MiddleName}}</div>
                        <div class="signature-line" style="text-align: center; margin-left: 40px;"></div>
                        <div>Signature over Printed Name</div>
                    </div>
                </td>
            </tr>
            <tr>
            </tr>
            
        </tbody>
    </div>

    <div class="footer">
        <img src="{{ $footer_Base64 }}" alt="Footer Photo" class="footer-photo" alt="Logo"  style="width:100%">
      </div>



    @endforeach
</body>
</html>
