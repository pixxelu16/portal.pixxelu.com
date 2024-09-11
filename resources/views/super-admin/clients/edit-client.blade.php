@extends('super-admin.layouts.master')
@section('content')
<div class="space-remove"></div>
<div class="title-subheading">
   <h2>Edit Client</h2>
</div>
<div class="main-table">
   @if (Session::has('success')) 
   <div class="notification-green">
      <p>{{ Session::get('success') }}</p>
   </div>
   @endif 
   @if (Session::has('unsuccess')) 
   <div class="notification-red">
      <p>{{ Session::get('unsuccess') }}</p>
   </div>
   @endif 
   <div class="login-form">
      <form action="{{ route('super.admin.update.client', $client_detail->id) }}" Method="POST">
         @csrf 
         <div class="form-group display-column">
            <div class="form-design first-name">
               <label for="client_name">Name</label>
               <input type="text" id="client_name" name="client_name" value="{{$client_detail->client_name}}" placeholder="Enter Client Name" required>
            </div>
            <div class="form-design mail">
               <label for="phone_no">Mobile</label>
               <input type="text" id="mobile" name="phone_no" value="{{$client_detail->phone_no}}" placeholder="Enter Mobile No" required>
            </div>
            <div class="form-design dob">
               <label for="desc">Description</label>
               <input type="text" id="desc" name="desc" value="{{$client_detail->desc}}" placeholder="Enter Description">
            </div>
         </div>
         <div class="form-group display-column">
            <div class="form-design mail">
               <label for="country">Country</label>
               <select class="form-control" name="country" id="country">
                  <option value="" disabled selected>Select Country</option>
                  <option value="AF" @if($client_detail->country == 'AF') selected @endif>Afghanistan</option>
                  <option value="AL" @if($client_detail->country == 'AL') selected @endif>Albania</option>
                  <option value="DZ" @if($client_detail->country == 'DZ') selected @endif>Algeria</option>
                  <option value="DZ" @if($client_detail->country == 'DZ') selected @endif>Andorra</option>
                  <option value="AO" @if($client_detail->country == 'AO') selected @endif>Angola</option>
                  <option value="AG" @if($client_detail->country == 'AG') selected @endif>Antigua and Barbuda</option>
                  <option value="AR" @if($client_detail->country == 'AR') selected @endif>Argentina</option>
                  <option value="AM" @if($client_detail->country == 'AM') selected @endif>Armenia</option>
                  <option value="AU" @if($client_detail->country == 'AU') selected @endif>Australia</option>
                  <option value="AT" @if($client_detail->country == 'AT') selected @endif>Austria</option>
                  <option value="AZ" @if($client_detail->country == 'AZ') selected @endif>Azerbaijan</option>
                  <option value="BS" @if($client_detail->country == 'BS') selected @endif>Bahamas</option>
                  <option value="BH" @if($client_detail->country == 'BH') selected @endif>Bahrain</option>
                  <option value="BD" @if($client_detail->country == 'BD') selected @endif>Bangladesh</option>
                  <option value="BB" @if($client_detail->country == 'BB') selected @endif>Barbados</option>
                  <option value="BY" @if($client_detail->country == 'BY') selected @endif>Belarus</option>
                  <option value="BE" @if($client_detail->country == 'BE') selected @endif>Belgium</option>
                  <option value="BZ" @if($client_detail->country == 'BZ') selected @endif>Belize</option>
                  <option value="BJ" @if($client_detail->country == 'BJ') selected @endif>Benin</option>
                  <option value="BT" @if($client_detail->country == 'BT') selected @endif>Bhutan</option>
                  <option value="BO" @if($client_detail->country == 'BO') selected @endif>Bolivia</option>
                  <option value="BA" @if($client_detail->country == 'BA') selected @endif>Bosnia and Herzegovina</option>
                  <option value="BW" @if($client_detail->country == 'BW') selected @endif>Botswana</option>
                  <option value="BR" @if($client_detail->country == 'BR') selected @endif>Brazil</option>
                  <option value="BN" @if($client_detail->country == 'BN') selected @endif>Brunei</option>
                  <option value="BG" @if($client_detail->country == 'BG') selected @endif>Bulgaria</option>
                  <option value="BF" @if($client_detail->country == 'BF') selected @endif>Burkina Faso</option>
                  <option value="BI" @if($client_detail->country == 'BI') selected @endif>Burundi</option>
                  <option value="CV" @if($client_detail->country == 'CV') selected @endif>Cabo Verde</option>
                  <option value="KH" @if($client_detail->country == 'KH') selected @endif>Cambodia</option>
                  <option value="CM" @if($client_detail->country == 'CM') selected @endif>Cameroon</option>
                  <option value="CA" @if($client_detail->country == 'CA') selected @endif>Canada</option>
                  <option value="CF" @if($client_detail->country == 'CF') selected @endif>Central African Republic</option>
                  <option value="TD" @if($client_detail->country == 'TD') selected @endif>Chad</option>
                  <option value="CL" @if($client_detail->country == 'CL') selected @endif>Chile</option>
                  <option value="CN" @if($client_detail->country == 'CN') selected @endif>China</option>
                  <option value="CO" @if($client_detail->country == 'CO') selected @endif>Colombia</option>
                  <option value="KM" @if($client_detail->country == 'KM') selected @endif>Comoros</option>
                  <option value="CG" @if($client_detail->country == 'CG') selected @endif>Congo</option>
                  <option value="CD" @if($client_detail->country == 'CD') selected @endif>Congo, Democratic Republic of the</option>
                  <option value="CR" @if($client_detail->country == 'CR') selected @endif>Costa Rica</option>
                  <option value="HR" @if($client_detail->country == 'HR') selected @endif>Croatia</option>
                  <option value="CU" @if($client_detail->country == 'CU') selected @endif>Cuba</option>
                  <option value="CY" @if($client_detail->country == 'CY') selected @endif>Cyprus</option>
                  <option value="CZ" @if($client_detail->country == 'CZ') selected @endif>Czech Republic</option>
                  <option value="DK" @if($client_detail->country == 'DK') selected @endif>Denmark</option>
                  <option value="DJ" @if($client_detail->country == 'DJ') selected @endif>Djibouti</option>
                  <option value="DM" @if($client_detail->country == 'DM') selected @endif>Dominica</option>
                  <option value="DO" @if($client_detail->country == 'DO') selected @endif>Dominican Republic</option>
                  <option value="EC" @if($client_detail->country == 'EC') selected @endif>Ecuador</option>
                  <option value="EG" @if($client_detail->country == 'EG') selected @endif>Egypt</option>
                  <option value="SV" @if($client_detail->country == 'SV') selected @endif>El Salvador</option>
                  <option value="GQ" @if($client_detail->country == 'GQ') selected @endif>Equatorial Guinea</option>
                  <option value="ER" @if($client_detail->country == 'ER') selected @endif>Eritrea</option>
                  <option value="EE" @if($client_detail->country == 'EE') selected @endif>Estonia</option>
                  <option value="SZ" @if($client_detail->country == 'SZ') selected @endif>Eswatini</option>
                  <option value="ET" @if($client_detail->country == 'ET') selected @endif>Ethiopia</option>
                  <option value="FJ" @if($client_detail->country == 'FJ') selected @endif>Fiji</option>
                  <option value="FI" @if($client_detail->country == 'FI') selected @endif>Finland</option>
                  <option value="FR" @if($client_detail->country == 'FR') selected @endif>France</option>
                  <option value="GA" @if($client_detail->country == 'GA') selected @endif>Gabon</option>
                  <option value="GM" @if($client_detail->country == 'GM') selected @endif>Gambia</option>
                  <option value="GE" @if($client_detail->country == 'GE') selected @endif>Georgia</option>
                  <option value="DE" @if($client_detail->country == 'DE') selected @endif>Germany</option>
                  <option value="GH" @if($client_detail->country == 'GH') selected @endif>Ghana</option>
                  <option value="GR" @if($client_detail->country == 'GR') selected @endif>Greece</option>
                  <option value="GD" @if($client_detail->country == 'GD') selected @endif>Grenada</option>
                  <option value="GT" @if($client_detail->country == 'GT') selected @endif>Guatemala</option>
                  <option value="GN" @if($client_detail->country == 'GN') selected @endif>Guinea</option>
                  <option value="GW" @if($client_detail->country == 'GW') selected @endif>Guinea-Bissau</option>
                  <option value="GY" @if($client_detail->country == 'GY') selected @endif>Guyana</option>
                  <option value="HT" @if($client_detail->country == 'HT') selected @endif>Haiti</option>
                  <option value="HN" @if($client_detail->country == 'HN') selected @endif>Honduras</option>
                  <option value="HU" @if($client_detail->country == 'HU') selected @endif>Hungary</option>
                  <option value="IS" @if($client_detail->country == 'IS') selected @endif>Iceland</option>
                  <option value="IN" @if($client_detail->country == 'IN') selected @endif>India</option>
                  <option value="ID" @if($client_detail->country == 'ID') selected @endif>Indonesia</option>
                  <option value="IR" @if($client_detail->country == 'IR') selected @endif>Iran</option>
                  <option value="IQ" @if($client_detail->country == 'IQ') selected @endif>Iraq</option>
                  <option value="IE" @if($client_detail->country == 'IE') selected @endif>Ireland</option>
                  <option value="IL" @if($client_detail->country == 'IL') selected @endif>Israel</option>
                  <option value="IT" @if($client_detail->country == 'IT') selected @endif>Italy</option>
                  <option value="JM" @if($client_detail->country == 'JM') selected @endif>Jamaica</option>
                  <option value="JP" @if($client_detail->country == 'JP') selected @endif>Japan</option>
                  <option value="JO" @if($client_detail->country == 'JO') selected @endif>Jordan</option>
                  <option value="KZ" @if($client_detail->country == 'KZ') selected @endif>Kazakhstan</option>
                  <option value="KE" @if($client_detail->country == 'KE') selected @endif>Kenya</option>
                  <option value="KI" @if($client_detail->country == 'KI') selected @endif>Kiribati</option>
                  <option value="KP" @if($client_detail->country == 'KP') selected @endif>Korea, North</option>
                  <option value="KR" @if($client_detail->country == 'KR') selected @endif>Korea, South</option>
                  <option value="KW" @if($client_detail->country == 'KW') selected @endif>Kuwait</option>
                  <option value="KG" @if($client_detail->country == 'KG') selected @endif>Kyrgyzstan</option>
                  <option value="LA" @if($client_detail->country == 'LA') selected @endif>Laos</option>
                  <option value="LV" @if($client_detail->country == 'LV') selected @endif>Latvia</option>
                  <option value="LB" @if($client_detail->country == 'LB') selected @endif>Lebanon</option>
                  <option value="LS" @if($client_detail->country == 'LS') selected @endif>Lesotho</option>
                  <option value="LR" @if($client_detail->country == 'LR') selected @endif>Liberia</option>
                  <option value="LY" @if($client_detail->country == 'LY') selected @endif>Libya</option>
                  <option value="LI" @if($client_detail->country == 'LI') selected @endif>Liechtenstein</option>
                  <option value="LT" @if($client_detail->country == 'LT') selected @endif>Lithuania</option>
                  <option value="LU" @if($client_detail->country == 'LU') selected @endif>Luxembourg</option>
                  <option value="MG" @if($client_detail->country == 'MG') selected @endif>Madagascar</option>
                  <option value="MW" @if($client_detail->country == 'MW') selected @endif>Malawi</option>
                  <option value="MY" @if($client_detail->country == 'MY') selected @endif>Malaysia</option>
                  <option value="MV" @if($client_detail->country == 'MV') selected @endif>Maldives</option>
                  <option value="ML" @if($client_detail->country == 'ML') selected @endif>Mali</option>
                  <option value="MT" @if($client_detail->country == 'MT') selected @endif>Malta</option>
                  <option value="MH" @if($client_detail->country == 'MH') selected @endif>Marshall Islands</option>
                  <option value="MR" @if($client_detail->country == 'MR') selected @endif>Mauritania</option>
                  <option value="MU" @if($client_detail->country == 'MU') selected @endif>Mauritius</option>
                  <option value="MX" @if($client_detail->country == 'MX') selected @endif >Mexico</option>
                  <option value="FM" @if($client_detail->country == 'FM') selected @endif>Micronesia</option>
                  <option value="MD" @if($client_detail->country == 'MD') selected @endif>Moldova</option>
                  <option value="MC" @if($client_detail->country == 'MC') selected @endif>Monaco</option>
                  <option value="MN" @if($client_detail->country == 'MN') selected @endif>Mongolia</option>
                  <option value="ME" @if($client_detail->country == 'ME') selected @endif>Montenegro</option>
                  <option value="MA" @if($client_detail->country == 'MA') selected @endif>Morocco</option>
                  <option value="MZ" @if($client_detail->country == 'MZ') selected @endif>Mozambique</option>
                  <option value="MM" @if($client_detail->country == 'MM') selected @endif>Myanmar</option>
                  <option value="NA" @if($client_detail->country == 'NA') selected @endif>Namibia</option>
                  <option value="NR" @if($client_detail->country == 'NR') selected @endif>Nauru</option>
                  <option value="NP" @if($client_detail->country == 'NP') selected @endif>Nepal</option>
                  <option value="NL" @if($client_detail->country == 'NL') selected @endif>Netherlands</option>
                  <option value="NZ" @if($client_detail->country == 'NZ') selected @endif>New Zealand</option>
                  <option value="NI" @if($client_detail->country == 'NI') selected @endif>Nicaragua</option>
                  <option value="NE" @if($client_detail->country == 'NE') selected @endif>Niger</option>
                  <option value="NG" @if($client_detail->country == 'NG') selected @endif>Nigeria</option>
                  <option value="NU" @if($client_detail->country == 'NU') selected @endif>Niue</option>
                  <option value="NF" @if($client_detail->country == 'NF') selected @endif>Norfolk Island</option>
                  <option value="MP" @if($client_detail->country == 'MP') selected @endif>Northern Mariana Islands</option>
                  <option value="NO" @if($client_detail->country == 'NO') selected @endif>Norway</option>
                  <option value="OM" @if($client_detail->country == 'OM') selected @endif>Oman</option>
                  <option value="PK" @if($client_detail->country == 'PK') selected @endif>Pakistan</option>
                  <option value="PW" @if($client_detail->country == 'PW') selected @endif>Palau</option>
                  <option value="PA" @if($client_detail->country == 'PA') selected @endif>Panama</option>
                  <option value="PG" @if($client_detail->country == 'PG') selected @endif>Papua New Guinea</option>
                  <option value="PY" @if($client_detail->country == 'PY') selected @endif>Paraguay</option>
                  <option value="PE" @if($client_detail->country == 'PE') selected @endif>Peru</option>
                  <option value="PH" @if($client_detail->country == 'PH') selected @endif>Philippines</option>
                  <option value="PN" @if($client_detail->country == 'PN') selected @endif>Pitcairn Islands</option>
                  <option value="PL" @if($client_detail->country == 'PL') selected @endif>Poland</option>
                  <option value="PT" @if($client_detail->country == 'PT') selected @endif>Portugal</option>
                  <option value="QA" @if($client_detail->country == 'QA') selected @endif>Qatar</option>
                  <option value="RO" @if($client_detail->country == 'RO') selected @endif>Romania</option>
                  <option value="RU" @if($client_detail->country == 'RU') selected @endif>Russia</option>
                  <option value="RW" @if($client_detail->country == 'RW') selected @endif>Rwanda</option>
                  <option value="WS" @if($client_detail->country == 'WS') selected @endif>Samoa</option>
                  <option value="SM" @if($client_detail->country == 'SM') selected @endif>San Marino</option>
                  <option value="SA" @if($client_detail->country == 'SA') selected @endif>Saudi Arabia</option>
                  <option value="SN" @if($client_detail->country == 'SN') selected @endif>Senegal</option>
                  <option value="RS" @if($client_detail->country == 'RS') selected @endif>Serbia</option>
                  <option value="SC" @if($client_detail->country == 'SC') selected @endif>Seychelles</option>
                  <option value="SL" @if($client_detail->country == 'SL') selected @endif>Sierra Leone</option>
                  <option value="SG" @if($client_detail->country == 'SG') selected @endif>Singapore</option>
                  <option value="SX" @if($client_detail->country == 'SX') selected @endif>Sint Maarten</option>
                  <option value="SK" @if($client_detail->country == 'SK') selected @endif>Slovakia</option>
                  <option value="SI" @if($client_detail->country == 'SI') selected @endif>Slovenia</option>
                  <option value="SB" @if($client_detail->country == 'SB') selected @endif>Solomon Islands</option>
                  <option value="SO" @if($client_detail->country == 'SO') selected @endif>Somalia</option>
                  <option value="ZA" @if($client_detail->country == 'ZA') selected @endif>South Africa</option>
                  <option value="SS" @if($client_detail->country == 'SS') selected @endif>South Sudan</option>
                  <option value="ES" @if($client_detail->country == 'ES') selected @endif>Spain</option>
                  <option value="LK" @if($client_detail->country == 'LK') selected @endif>Sri Lanka</option>
                  <option value="SD" @if($client_detail->country == 'SD') selected @endif>Sudan</option>
                  <option value="SR" @if($client_detail->country == 'SR') selected @endif>Suriname</option>
                  <option value="SZ" @if($client_detail->country == 'SZ') selected @endif>Swaziland</option>
                  <option value="SE" @if($client_detail->country == 'SE') selected @endif>Sweden</option>
                  <option value="CH" @if($client_detail->country == 'CH') selected @endif>Switzerland</option>
                  <option value="SY" @if($client_detail->country == 'SY') selected @endif>Syria</option>
                  <option value="TW" @if($client_detail->country == 'TW') selected @endif>Taiwan</option>
                  <option value="TJ" @if($client_detail->country == 'TJ') selected @endif>Tajikistan</option>
                  <option value="TZ" @if($client_detail->country == 'TZ') selected @endif>Tanzania</option>
                  <option value="TH" @if($client_detail->country == 'TH') selected @endif>Thailand</option>
                  <option value="TL" @if($client_detail->country == 'TL') selected @endif>Timor-Leste</option>
                  <option value="TG" @if($client_detail->country == 'TG') selected @endif>Togo</option>
                  <option value="TK" @if($client_detail->country == 'TK') selected @endif>Tokelau</option>
                  <option value="TO" @if($client_detail->country == 'TO') selected @endif>Tonga</option>
                  <option value="TT" @if($client_detail->country == 'TT') selected @endif>Trinidad and Tobago</option>
                  <option value="TN" @if($client_detail->country == 'TN') selected @endif>Tunisia</option>
                  <option value="TR" @if($client_detail->country == 'TR') selected @endif>Turkey</option>
                  <option value="TM" @if($client_detail->country == 'TW') selected @endif>Turkmenistan</option>
                  <option value="TV" @if($client_detail->country == 'TV') selected @endif>Tuvalu</option>
                  <option value="UG" @if($client_detail->country == 'UG') selected @endif>Uganda</option>
                  <option value="UA" @if($client_detail->country == 'UA') selected @endif>Ukraine</option>
                  <option value="AE" @if($client_detail->country == 'AE') selected @endif >United Arab Emirates</option>
                  <option value="GB" @if($client_detail->country == 'GB') selected @endif>United Kingdom</option>
                  <option value="US" @if($client_detail->country == 'US') selected @endif>United States</option>
                  <option value="UY" @if($client_detail->country == 'UY') selected @endif>Uruguay</option>
                  <option value="UZ" @if($client_detail->country == 'UZ') selected @endif>Uzbekistan</option>
                  <option value="VU" @if($client_detail->country == 'VU') selected @endif>Vanuatu</option>
                  <option value="VA" @if($client_detail->country == 'VA') selected @endif>Vatican City</option>
                  <option value="VE" @if($client_detail->country == 'VE') selected @endif>Venezuela</option>
                  <option value="VN" @if($client_detail->country == 'VN') selected @endif>Vietnam</option>
                  <option value="WF" @if($client_detail->country == 'WF') selected @endif>Wallis and Futuna</option>
                  <option value="EH" @if($client_detail->country == 'EH') selected @endif>Western Sahara</option>
                  <option value="YE" @if($client_detail->country == 'YE') selected @endif>Yemen</option>
                  <option value="ZM" @if($client_detail->country == 'ZM') selected @endif>Zambia</option>
                  <option value="ZW" @if($client_detail->country == 'ZW') selected @endif>Zimbabwe</option>
               </select>
            </div>
            <div class="form-design fees">
               <label for="from">From</label>
               <select class="form-control" name="from" id="client from">
                  <option value ="" disabled selected>Select From Type</option>
                  <option value="1" @if($client_detail->from == '1') selected @endif>1</option>
                  <option value="2" @if($client_detail->from == '2') selected @endif>2</option>
                  <option value="3" @if($client_detail->from == '3') selected @endif>3</option>
                  <option value="4" @if($client_detail->from == '4') selected @endif>4</option>
                  <option value="5" @if($client_detail->from == '5') selected @endif>5</option>
               </select>
            </div>
            <div class="form-design fees">
            <label for="status">Status</label>
            <select class="form-control" name="client_status" id="client status">
               <option value ="" disabled selected>Select Status Type</option>
               <option value="Active" @if($client_detail->client_status == 'Active') selected @endif>Active</option>
                <option value="Pending" @if($client_detail->client_status == 'Pending') selected @endif>Pending</option>
                <option value="Suspend" @if($client_detail->client_status == 'Suspend') selected @endif>Suspend</option>
                <option value="Completed" @if($client_detail->client_status == 'Completed') selected @endif>Completed</option>
                <option value="Converted" @if($client_detail->client_status == 'Converted') selected @endif>Converted</option>
                <option value="Leave" @if($client_detail->client_status == 'Leave') selected @endif>Leave</option>
            </select>
         </div>
         </div>
         <div class="form-button">
            <div class="back-button">
               <input type="submit" class="btn btn-success" name="submit" value="Update">
            </div>
         </div>
   </div>
   </form>
</div>
</div>
<script>
   const mobileInput = document.getElementById('mobile');
   mobileInput.addEventListener('input', function(event) {
      const inputValue = event.target.value;
      const numericValue = inputValue.replace(/\D/g, ''); 
      const truncatedValue = numericValue.slice(0, 10); 
      event.target.value = truncatedValue;
   });
</script>
@endsection