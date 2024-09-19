<?php $__env->startSection('content'); ?>
<div class="space-remove"></div>
<div class="title-subheading">
   <h2>Edit Client</h2>
</div>
<div class="main-table">
   <?php if(Session::has('success')): ?> 
   <div class="notification-green">
      <p><?php echo e(Session::get('success')); ?></p>
   </div>
   <?php endif; ?> 
   <?php if(Session::has('unsuccess')): ?> 
   <div class="notification-red">
      <p><?php echo e(Session::get('unsuccess')); ?></p>
   </div>
   <?php endif; ?> 
   <div class="login-form">
      <form action="<?php echo e(route('super.admin.update.client', $client_detail->id)); ?>" Method="POST">
         <?php echo csrf_field(); ?> 
         <div class="form-group display-column">
            <div class="form-design first-name">
               <label for="client_name">Name</label>
               <input type="text" id="client_name" name="client_name" value="<?php echo e($client_detail->client_name); ?>" placeholder="Enter Client Name" required>
            </div>
            <div class="form-design mail">
               <label for="phone_no">Mobile</label>
               <input type="text" id="mobile" name="phone_no" value="<?php echo e($client_detail->phone_no); ?>" placeholder="Enter Mobile No" required>
            </div>
            <div class="form-design dob">
               <label for="desc">Description</label>
               <input type="text" id="desc" name="desc" value="<?php echo e($client_detail->desc); ?>" placeholder="Enter Description">
            </div>
         </div>
         <div class="form-group display-column">
            <div class="form-design mail">
               <label for="country">Country</label>
               <select class="form-control" name="country" id="country">
                  <option value="" disabled selected>Select Country</option>
                  <option value="AF" <?php if($client_detail->country == 'AF'): ?> selected <?php endif; ?>>Afghanistan</option>
                  <option value="AL" <?php if($client_detail->country == 'AL'): ?> selected <?php endif; ?>>Albania</option>
                  <option value="DZ" <?php if($client_detail->country == 'DZ'): ?> selected <?php endif; ?>>Algeria</option>
                  <option value="DZ" <?php if($client_detail->country == 'DZ'): ?> selected <?php endif; ?>>Andorra</option>
                  <option value="AO" <?php if($client_detail->country == 'AO'): ?> selected <?php endif; ?>>Angola</option>
                  <option value="AG" <?php if($client_detail->country == 'AG'): ?> selected <?php endif; ?>>Antigua and Barbuda</option>
                  <option value="AR" <?php if($client_detail->country == 'AR'): ?> selected <?php endif; ?>>Argentina</option>
                  <option value="AM" <?php if($client_detail->country == 'AM'): ?> selected <?php endif; ?>>Armenia</option>
                  <option value="AU" <?php if($client_detail->country == 'AU'): ?> selected <?php endif; ?>>Australia</option>
                  <option value="AT" <?php if($client_detail->country == 'AT'): ?> selected <?php endif; ?>>Austria</option>
                  <option value="AZ" <?php if($client_detail->country == 'AZ'): ?> selected <?php endif; ?>>Azerbaijan</option>
                  <option value="BS" <?php if($client_detail->country == 'BS'): ?> selected <?php endif; ?>>Bahamas</option>
                  <option value="BH" <?php if($client_detail->country == 'BH'): ?> selected <?php endif; ?>>Bahrain</option>
                  <option value="BD" <?php if($client_detail->country == 'BD'): ?> selected <?php endif; ?>>Bangladesh</option>
                  <option value="BB" <?php if($client_detail->country == 'BB'): ?> selected <?php endif; ?>>Barbados</option>
                  <option value="BY" <?php if($client_detail->country == 'BY'): ?> selected <?php endif; ?>>Belarus</option>
                  <option value="BE" <?php if($client_detail->country == 'BE'): ?> selected <?php endif; ?>>Belgium</option>
                  <option value="BZ" <?php if($client_detail->country == 'BZ'): ?> selected <?php endif; ?>>Belize</option>
                  <option value="BJ" <?php if($client_detail->country == 'BJ'): ?> selected <?php endif; ?>>Benin</option>
                  <option value="BT" <?php if($client_detail->country == 'BT'): ?> selected <?php endif; ?>>Bhutan</option>
                  <option value="BO" <?php if($client_detail->country == 'BO'): ?> selected <?php endif; ?>>Bolivia</option>
                  <option value="BA" <?php if($client_detail->country == 'BA'): ?> selected <?php endif; ?>>Bosnia and Herzegovina</option>
                  <option value="BW" <?php if($client_detail->country == 'BW'): ?> selected <?php endif; ?>>Botswana</option>
                  <option value="BR" <?php if($client_detail->country == 'BR'): ?> selected <?php endif; ?>>Brazil</option>
                  <option value="BN" <?php if($client_detail->country == 'BN'): ?> selected <?php endif; ?>>Brunei</option>
                  <option value="BG" <?php if($client_detail->country == 'BG'): ?> selected <?php endif; ?>>Bulgaria</option>
                  <option value="BF" <?php if($client_detail->country == 'BF'): ?> selected <?php endif; ?>>Burkina Faso</option>
                  <option value="BI" <?php if($client_detail->country == 'BI'): ?> selected <?php endif; ?>>Burundi</option>
                  <option value="CV" <?php if($client_detail->country == 'CV'): ?> selected <?php endif; ?>>Cabo Verde</option>
                  <option value="KH" <?php if($client_detail->country == 'KH'): ?> selected <?php endif; ?>>Cambodia</option>
                  <option value="CM" <?php if($client_detail->country == 'CM'): ?> selected <?php endif; ?>>Cameroon</option>
                  <option value="CA" <?php if($client_detail->country == 'CA'): ?> selected <?php endif; ?>>Canada</option>
                  <option value="CF" <?php if($client_detail->country == 'CF'): ?> selected <?php endif; ?>>Central African Republic</option>
                  <option value="TD" <?php if($client_detail->country == 'TD'): ?> selected <?php endif; ?>>Chad</option>
                  <option value="CL" <?php if($client_detail->country == 'CL'): ?> selected <?php endif; ?>>Chile</option>
                  <option value="CN" <?php if($client_detail->country == 'CN'): ?> selected <?php endif; ?>>China</option>
                  <option value="CO" <?php if($client_detail->country == 'CO'): ?> selected <?php endif; ?>>Colombia</option>
                  <option value="KM" <?php if($client_detail->country == 'KM'): ?> selected <?php endif; ?>>Comoros</option>
                  <option value="CG" <?php if($client_detail->country == 'CG'): ?> selected <?php endif; ?>>Congo</option>
                  <option value="CD" <?php if($client_detail->country == 'CD'): ?> selected <?php endif; ?>>Congo, Democratic Republic of the</option>
                  <option value="CR" <?php if($client_detail->country == 'CR'): ?> selected <?php endif; ?>>Costa Rica</option>
                  <option value="HR" <?php if($client_detail->country == 'HR'): ?> selected <?php endif; ?>>Croatia</option>
                  <option value="CU" <?php if($client_detail->country == 'CU'): ?> selected <?php endif; ?>>Cuba</option>
                  <option value="CY" <?php if($client_detail->country == 'CY'): ?> selected <?php endif; ?>>Cyprus</option>
                  <option value="CZ" <?php if($client_detail->country == 'CZ'): ?> selected <?php endif; ?>>Czech Republic</option>
                  <option value="DK" <?php if($client_detail->country == 'DK'): ?> selected <?php endif; ?>>Denmark</option>
                  <option value="DJ" <?php if($client_detail->country == 'DJ'): ?> selected <?php endif; ?>>Djibouti</option>
                  <option value="DM" <?php if($client_detail->country == 'DM'): ?> selected <?php endif; ?>>Dominica</option>
                  <option value="DO" <?php if($client_detail->country == 'DO'): ?> selected <?php endif; ?>>Dominican Republic</option>
                  <option value="EC" <?php if($client_detail->country == 'EC'): ?> selected <?php endif; ?>>Ecuador</option>
                  <option value="EG" <?php if($client_detail->country == 'EG'): ?> selected <?php endif; ?>>Egypt</option>
                  <option value="SV" <?php if($client_detail->country == 'SV'): ?> selected <?php endif; ?>>El Salvador</option>
                  <option value="GQ" <?php if($client_detail->country == 'GQ'): ?> selected <?php endif; ?>>Equatorial Guinea</option>
                  <option value="ER" <?php if($client_detail->country == 'ER'): ?> selected <?php endif; ?>>Eritrea</option>
                  <option value="EE" <?php if($client_detail->country == 'EE'): ?> selected <?php endif; ?>>Estonia</option>
                  <option value="SZ" <?php if($client_detail->country == 'SZ'): ?> selected <?php endif; ?>>Eswatini</option>
                  <option value="ET" <?php if($client_detail->country == 'ET'): ?> selected <?php endif; ?>>Ethiopia</option>
                  <option value="FJ" <?php if($client_detail->country == 'FJ'): ?> selected <?php endif; ?>>Fiji</option>
                  <option value="FI" <?php if($client_detail->country == 'FI'): ?> selected <?php endif; ?>>Finland</option>
                  <option value="FR" <?php if($client_detail->country == 'FR'): ?> selected <?php endif; ?>>France</option>
                  <option value="GA" <?php if($client_detail->country == 'GA'): ?> selected <?php endif; ?>>Gabon</option>
                  <option value="GM" <?php if($client_detail->country == 'GM'): ?> selected <?php endif; ?>>Gambia</option>
                  <option value="GE" <?php if($client_detail->country == 'GE'): ?> selected <?php endif; ?>>Georgia</option>
                  <option value="DE" <?php if($client_detail->country == 'DE'): ?> selected <?php endif; ?>>Germany</option>
                  <option value="GH" <?php if($client_detail->country == 'GH'): ?> selected <?php endif; ?>>Ghana</option>
                  <option value="GR" <?php if($client_detail->country == 'GR'): ?> selected <?php endif; ?>>Greece</option>
                  <option value="GD" <?php if($client_detail->country == 'GD'): ?> selected <?php endif; ?>>Grenada</option>
                  <option value="GT" <?php if($client_detail->country == 'GT'): ?> selected <?php endif; ?>>Guatemala</option>
                  <option value="GN" <?php if($client_detail->country == 'GN'): ?> selected <?php endif; ?>>Guinea</option>
                  <option value="GW" <?php if($client_detail->country == 'GW'): ?> selected <?php endif; ?>>Guinea-Bissau</option>
                  <option value="GY" <?php if($client_detail->country == 'GY'): ?> selected <?php endif; ?>>Guyana</option>
                  <option value="HT" <?php if($client_detail->country == 'HT'): ?> selected <?php endif; ?>>Haiti</option>
                  <option value="HN" <?php if($client_detail->country == 'HN'): ?> selected <?php endif; ?>>Honduras</option>
                  <option value="HU" <?php if($client_detail->country == 'HU'): ?> selected <?php endif; ?>>Hungary</option>
                  <option value="IS" <?php if($client_detail->country == 'IS'): ?> selected <?php endif; ?>>Iceland</option>
                  <option value="IN" <?php if($client_detail->country == 'IN'): ?> selected <?php endif; ?>>India</option>
                  <option value="ID" <?php if($client_detail->country == 'ID'): ?> selected <?php endif; ?>>Indonesia</option>
                  <option value="IR" <?php if($client_detail->country == 'IR'): ?> selected <?php endif; ?>>Iran</option>
                  <option value="IQ" <?php if($client_detail->country == 'IQ'): ?> selected <?php endif; ?>>Iraq</option>
                  <option value="IE" <?php if($client_detail->country == 'IE'): ?> selected <?php endif; ?>>Ireland</option>
                  <option value="IL" <?php if($client_detail->country == 'IL'): ?> selected <?php endif; ?>>Israel</option>
                  <option value="IT" <?php if($client_detail->country == 'IT'): ?> selected <?php endif; ?>>Italy</option>
                  <option value="JM" <?php if($client_detail->country == 'JM'): ?> selected <?php endif; ?>>Jamaica</option>
                  <option value="JP" <?php if($client_detail->country == 'JP'): ?> selected <?php endif; ?>>Japan</option>
                  <option value="JO" <?php if($client_detail->country == 'JO'): ?> selected <?php endif; ?>>Jordan</option>
                  <option value="KZ" <?php if($client_detail->country == 'KZ'): ?> selected <?php endif; ?>>Kazakhstan</option>
                  <option value="KE" <?php if($client_detail->country == 'KE'): ?> selected <?php endif; ?>>Kenya</option>
                  <option value="KI" <?php if($client_detail->country == 'KI'): ?> selected <?php endif; ?>>Kiribati</option>
                  <option value="KP" <?php if($client_detail->country == 'KP'): ?> selected <?php endif; ?>>Korea, North</option>
                  <option value="KR" <?php if($client_detail->country == 'KR'): ?> selected <?php endif; ?>>Korea, South</option>
                  <option value="KW" <?php if($client_detail->country == 'KW'): ?> selected <?php endif; ?>>Kuwait</option>
                  <option value="KG" <?php if($client_detail->country == 'KG'): ?> selected <?php endif; ?>>Kyrgyzstan</option>
                  <option value="LA" <?php if($client_detail->country == 'LA'): ?> selected <?php endif; ?>>Laos</option>
                  <option value="LV" <?php if($client_detail->country == 'LV'): ?> selected <?php endif; ?>>Latvia</option>
                  <option value="LB" <?php if($client_detail->country == 'LB'): ?> selected <?php endif; ?>>Lebanon</option>
                  <option value="LS" <?php if($client_detail->country == 'LS'): ?> selected <?php endif; ?>>Lesotho</option>
                  <option value="LR" <?php if($client_detail->country == 'LR'): ?> selected <?php endif; ?>>Liberia</option>
                  <option value="LY" <?php if($client_detail->country == 'LY'): ?> selected <?php endif; ?>>Libya</option>
                  <option value="LI" <?php if($client_detail->country == 'LI'): ?> selected <?php endif; ?>>Liechtenstein</option>
                  <option value="LT" <?php if($client_detail->country == 'LT'): ?> selected <?php endif; ?>>Lithuania</option>
                  <option value="LU" <?php if($client_detail->country == 'LU'): ?> selected <?php endif; ?>>Luxembourg</option>
                  <option value="MG" <?php if($client_detail->country == 'MG'): ?> selected <?php endif; ?>>Madagascar</option>
                  <option value="MW" <?php if($client_detail->country == 'MW'): ?> selected <?php endif; ?>>Malawi</option>
                  <option value="MY" <?php if($client_detail->country == 'MY'): ?> selected <?php endif; ?>>Malaysia</option>
                  <option value="MV" <?php if($client_detail->country == 'MV'): ?> selected <?php endif; ?>>Maldives</option>
                  <option value="ML" <?php if($client_detail->country == 'ML'): ?> selected <?php endif; ?>>Mali</option>
                  <option value="MT" <?php if($client_detail->country == 'MT'): ?> selected <?php endif; ?>>Malta</option>
                  <option value="MH" <?php if($client_detail->country == 'MH'): ?> selected <?php endif; ?>>Marshall Islands</option>
                  <option value="MR" <?php if($client_detail->country == 'MR'): ?> selected <?php endif; ?>>Mauritania</option>
                  <option value="MU" <?php if($client_detail->country == 'MU'): ?> selected <?php endif; ?>>Mauritius</option>
                  <option value="MX" <?php if($client_detail->country == 'MX'): ?> selected <?php endif; ?> >Mexico</option>
                  <option value="FM" <?php if($client_detail->country == 'FM'): ?> selected <?php endif; ?>>Micronesia</option>
                  <option value="MD" <?php if($client_detail->country == 'MD'): ?> selected <?php endif; ?>>Moldova</option>
                  <option value="MC" <?php if($client_detail->country == 'MC'): ?> selected <?php endif; ?>>Monaco</option>
                  <option value="MN" <?php if($client_detail->country == 'MN'): ?> selected <?php endif; ?>>Mongolia</option>
                  <option value="ME" <?php if($client_detail->country == 'ME'): ?> selected <?php endif; ?>>Montenegro</option>
                  <option value="MA" <?php if($client_detail->country == 'MA'): ?> selected <?php endif; ?>>Morocco</option>
                  <option value="MZ" <?php if($client_detail->country == 'MZ'): ?> selected <?php endif; ?>>Mozambique</option>
                  <option value="MM" <?php if($client_detail->country == 'MM'): ?> selected <?php endif; ?>>Myanmar</option>
                  <option value="NA" <?php if($client_detail->country == 'NA'): ?> selected <?php endif; ?>>Namibia</option>
                  <option value="NR" <?php if($client_detail->country == 'NR'): ?> selected <?php endif; ?>>Nauru</option>
                  <option value="NP" <?php if($client_detail->country == 'NP'): ?> selected <?php endif; ?>>Nepal</option>
                  <option value="NL" <?php if($client_detail->country == 'NL'): ?> selected <?php endif; ?>>Netherlands</option>
                  <option value="NZ" <?php if($client_detail->country == 'NZ'): ?> selected <?php endif; ?>>New Zealand</option>
                  <option value="NI" <?php if($client_detail->country == 'NI'): ?> selected <?php endif; ?>>Nicaragua</option>
                  <option value="NE" <?php if($client_detail->country == 'NE'): ?> selected <?php endif; ?>>Niger</option>
                  <option value="NG" <?php if($client_detail->country == 'NG'): ?> selected <?php endif; ?>>Nigeria</option>
                  <option value="NU" <?php if($client_detail->country == 'NU'): ?> selected <?php endif; ?>>Niue</option>
                  <option value="NF" <?php if($client_detail->country == 'NF'): ?> selected <?php endif; ?>>Norfolk Island</option>
                  <option value="MP" <?php if($client_detail->country == 'MP'): ?> selected <?php endif; ?>>Northern Mariana Islands</option>
                  <option value="NO" <?php if($client_detail->country == 'NO'): ?> selected <?php endif; ?>>Norway</option>
                  <option value="OM" <?php if($client_detail->country == 'OM'): ?> selected <?php endif; ?>>Oman</option>
                  <option value="PK" <?php if($client_detail->country == 'PK'): ?> selected <?php endif; ?>>Pakistan</option>
                  <option value="PW" <?php if($client_detail->country == 'PW'): ?> selected <?php endif; ?>>Palau</option>
                  <option value="PA" <?php if($client_detail->country == 'PA'): ?> selected <?php endif; ?>>Panama</option>
                  <option value="PG" <?php if($client_detail->country == 'PG'): ?> selected <?php endif; ?>>Papua New Guinea</option>
                  <option value="PY" <?php if($client_detail->country == 'PY'): ?> selected <?php endif; ?>>Paraguay</option>
                  <option value="PE" <?php if($client_detail->country == 'PE'): ?> selected <?php endif; ?>>Peru</option>
                  <option value="PH" <?php if($client_detail->country == 'PH'): ?> selected <?php endif; ?>>Philippines</option>
                  <option value="PN" <?php if($client_detail->country == 'PN'): ?> selected <?php endif; ?>>Pitcairn Islands</option>
                  <option value="PL" <?php if($client_detail->country == 'PL'): ?> selected <?php endif; ?>>Poland</option>
                  <option value="PT" <?php if($client_detail->country == 'PT'): ?> selected <?php endif; ?>>Portugal</option>
                  <option value="QA" <?php if($client_detail->country == 'QA'): ?> selected <?php endif; ?>>Qatar</option>
                  <option value="RO" <?php if($client_detail->country == 'RO'): ?> selected <?php endif; ?>>Romania</option>
                  <option value="RU" <?php if($client_detail->country == 'RU'): ?> selected <?php endif; ?>>Russia</option>
                  <option value="RW" <?php if($client_detail->country == 'RW'): ?> selected <?php endif; ?>>Rwanda</option>
                  <option value="WS" <?php if($client_detail->country == 'WS'): ?> selected <?php endif; ?>>Samoa</option>
                  <option value="SM" <?php if($client_detail->country == 'SM'): ?> selected <?php endif; ?>>San Marino</option>
                  <option value="SA" <?php if($client_detail->country == 'SA'): ?> selected <?php endif; ?>>Saudi Arabia</option>
                  <option value="SN" <?php if($client_detail->country == 'SN'): ?> selected <?php endif; ?>>Senegal</option>
                  <option value="RS" <?php if($client_detail->country == 'RS'): ?> selected <?php endif; ?>>Serbia</option>
                  <option value="SC" <?php if($client_detail->country == 'SC'): ?> selected <?php endif; ?>>Seychelles</option>
                  <option value="SL" <?php if($client_detail->country == 'SL'): ?> selected <?php endif; ?>>Sierra Leone</option>
                  <option value="SG" <?php if($client_detail->country == 'SG'): ?> selected <?php endif; ?>>Singapore</option>
                  <option value="SX" <?php if($client_detail->country == 'SX'): ?> selected <?php endif; ?>>Sint Maarten</option>
                  <option value="SK" <?php if($client_detail->country == 'SK'): ?> selected <?php endif; ?>>Slovakia</option>
                  <option value="SI" <?php if($client_detail->country == 'SI'): ?> selected <?php endif; ?>>Slovenia</option>
                  <option value="SB" <?php if($client_detail->country == 'SB'): ?> selected <?php endif; ?>>Solomon Islands</option>
                  <option value="SO" <?php if($client_detail->country == 'SO'): ?> selected <?php endif; ?>>Somalia</option>
                  <option value="ZA" <?php if($client_detail->country == 'ZA'): ?> selected <?php endif; ?>>South Africa</option>
                  <option value="SS" <?php if($client_detail->country == 'SS'): ?> selected <?php endif; ?>>South Sudan</option>
                  <option value="ES" <?php if($client_detail->country == 'ES'): ?> selected <?php endif; ?>>Spain</option>
                  <option value="LK" <?php if($client_detail->country == 'LK'): ?> selected <?php endif; ?>>Sri Lanka</option>
                  <option value="SD" <?php if($client_detail->country == 'SD'): ?> selected <?php endif; ?>>Sudan</option>
                  <option value="SR" <?php if($client_detail->country == 'SR'): ?> selected <?php endif; ?>>Suriname</option>
                  <option value="SZ" <?php if($client_detail->country == 'SZ'): ?> selected <?php endif; ?>>Swaziland</option>
                  <option value="SE" <?php if($client_detail->country == 'SE'): ?> selected <?php endif; ?>>Sweden</option>
                  <option value="CH" <?php if($client_detail->country == 'CH'): ?> selected <?php endif; ?>>Switzerland</option>
                  <option value="SY" <?php if($client_detail->country == 'SY'): ?> selected <?php endif; ?>>Syria</option>
                  <option value="TW" <?php if($client_detail->country == 'TW'): ?> selected <?php endif; ?>>Taiwan</option>
                  <option value="TJ" <?php if($client_detail->country == 'TJ'): ?> selected <?php endif; ?>>Tajikistan</option>
                  <option value="TZ" <?php if($client_detail->country == 'TZ'): ?> selected <?php endif; ?>>Tanzania</option>
                  <option value="TH" <?php if($client_detail->country == 'TH'): ?> selected <?php endif; ?>>Thailand</option>
                  <option value="TL" <?php if($client_detail->country == 'TL'): ?> selected <?php endif; ?>>Timor-Leste</option>
                  <option value="TG" <?php if($client_detail->country == 'TG'): ?> selected <?php endif; ?>>Togo</option>
                  <option value="TK" <?php if($client_detail->country == 'TK'): ?> selected <?php endif; ?>>Tokelau</option>
                  <option value="TO" <?php if($client_detail->country == 'TO'): ?> selected <?php endif; ?>>Tonga</option>
                  <option value="TT" <?php if($client_detail->country == 'TT'): ?> selected <?php endif; ?>>Trinidad and Tobago</option>
                  <option value="TN" <?php if($client_detail->country == 'TN'): ?> selected <?php endif; ?>>Tunisia</option>
                  <option value="TR" <?php if($client_detail->country == 'TR'): ?> selected <?php endif; ?>>Turkey</option>
                  <option value="TM" <?php if($client_detail->country == 'TW'): ?> selected <?php endif; ?>>Turkmenistan</option>
                  <option value="TV" <?php if($client_detail->country == 'TV'): ?> selected <?php endif; ?>>Tuvalu</option>
                  <option value="UG" <?php if($client_detail->country == 'UG'): ?> selected <?php endif; ?>>Uganda</option>
                  <option value="UA" <?php if($client_detail->country == 'UA'): ?> selected <?php endif; ?>>Ukraine</option>
                  <option value="AE" <?php if($client_detail->country == 'AE'): ?> selected <?php endif; ?> >United Arab Emirates</option>
                  <option value="GB" <?php if($client_detail->country == 'GB'): ?> selected <?php endif; ?>>United Kingdom</option>
                  <option value="US" <?php if($client_detail->country == 'US'): ?> selected <?php endif; ?>>United States</option>
                  <option value="UY" <?php if($client_detail->country == 'UY'): ?> selected <?php endif; ?>>Uruguay</option>
                  <option value="UZ" <?php if($client_detail->country == 'UZ'): ?> selected <?php endif; ?>>Uzbekistan</option>
                  <option value="VU" <?php if($client_detail->country == 'VU'): ?> selected <?php endif; ?>>Vanuatu</option>
                  <option value="VA" <?php if($client_detail->country == 'VA'): ?> selected <?php endif; ?>>Vatican City</option>
                  <option value="VE" <?php if($client_detail->country == 'VE'): ?> selected <?php endif; ?>>Venezuela</option>
                  <option value="VN" <?php if($client_detail->country == 'VN'): ?> selected <?php endif; ?>>Vietnam</option>
                  <option value="WF" <?php if($client_detail->country == 'WF'): ?> selected <?php endif; ?>>Wallis and Futuna</option>
                  <option value="EH" <?php if($client_detail->country == 'EH'): ?> selected <?php endif; ?>>Western Sahara</option>
                  <option value="YE" <?php if($client_detail->country == 'YE'): ?> selected <?php endif; ?>>Yemen</option>
                  <option value="ZM" <?php if($client_detail->country == 'ZM'): ?> selected <?php endif; ?>>Zambia</option>
                  <option value="ZW" <?php if($client_detail->country == 'ZW'): ?> selected <?php endif; ?>>Zimbabwe</option>
               </select>
            </div>
            <div class="form-design fees">
               <label for="from">From</label>
               <select class="form-control" name="from" id="client from">
                  <option value ="" disabled selected>Select From Type</option>
                  <option value="1" <?php if($client_detail->from == '1'): ?> selected <?php endif; ?>>1</option>
                  <option value="2" <?php if($client_detail->from == '2'): ?> selected <?php endif; ?>>2</option>
                  <option value="3" <?php if($client_detail->from == '3'): ?> selected <?php endif; ?>>3</option>
                  <option value="4" <?php if($client_detail->from == '4'): ?> selected <?php endif; ?>>4</option>
                  <option value="5" <?php if($client_detail->from == '5'): ?> selected <?php endif; ?>>5</option>
               </select>
            </div>
            <div class="form-design fees">
            <label for="status">Status</label>
            <select class="form-control" name="client_status" id="client status">
               <option value ="" disabled selected>Select Status Type</option>
               <option value="Active" <?php if($client_detail->client_status == 'Active'): ?> selected <?php endif; ?>>Active</option>
                <option value="Pending" <?php if($client_detail->client_status == 'Pending'): ?> selected <?php endif; ?>>Pending</option>
                <option value="Suspend" <?php if($client_detail->client_status == 'Suspend'): ?> selected <?php endif; ?>>Suspend</option>
                <option value="Completed" <?php if($client_detail->client_status == 'Completed'): ?> selected <?php endif; ?>>Completed</option>
                <option value="Converted" <?php if($client_detail->client_status == 'Converted'): ?> selected <?php endif; ?>>Converted</option>
                <option value="Leave" <?php if($client_detail->client_status == 'Leave'): ?> selected <?php endif; ?>>Leave</option>
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
<?php $__env->stopSection(); ?>
<?php echo $__env->make('super-admin.layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\xampp\htdocs\pixxelu-student-portal-new\resources\views/super-admin/clients/edit-client.blade.php ENDPATH**/ ?>