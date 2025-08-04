'use strict';

var mypage = angular.module('mainpage', ['pascalprecht.translate', 'ui.bootstrap']);


// ADD THIS ENTIRE CONFIGURATION BLOCK
mypage.config(function ($translateProvider) {
  
  // English translations
  $translateProvider.translations('en', {
    'USER_MANAGEMENT': 'User Management',
    'ALL_USERS': 'All Users',
    'SEARCH_PLACEHOLDER': 'Search ...',
    'FILTERS': 'Filters',
    'ADD_USER': 'Add User',
    'NAME': 'Name',
    'ID_NUMBER': 'ID Number',
    'REGION': 'Region',
    'CITY': 'City',
    'GOVERNORATE': 'Governorate',
    'PHONE':'Phone Number',
    'FULL ENG NAME':'Full Name',
    // Add User Form
'ADD_USER_FORM': 'Add User',
'FULL_ENG_NAME': 'Full English Name',
'FULL_ARAB_NAME': 'Full Arabic Name',
'DOB': 'Date of Birth',
'SUBMIT': 'Add User',
'CANCEL': 'Cancel',
'ENG_NAME_PLACEHOLDER': 'Enter your full name in English',
'ARAB_NAME_PLACEHOLDER': 'أدخل اسمك الكامل بالعربية',
    'ACTIONS': 'Actions',
    'ADD': 'Add',
    'SHOW_MINORS': 'Show Minors',
    'DELETE': 'Delete',
    'EDITE':'edite',
    // Regions
        'WEST_BANK': 'West Bank',
        'GAZA_STRIP': 'Gaza Strip',
        // Cities
        'NABLUS': 'Nablus',
        'RAMALLAH': 'Ramallah',
        'HEBRON': 'Hebron',
        'JERUSALEM': 'Jerusalem',
        'BETHLEHEM': 'Bethlehem',
        'JENIN': 'Jenin',
        'TULKARM': 'Tulkarm',
        'QALQILYA': 'Qalqilya',
        'SALFIT': 'Salfit',
        'JERICHO': 'Jericho',
        'GAZA': 'Gaza',
        'KHAN_YOUNIS': 'Khan Younis',
        'RAFAH': 'Rafah',
        // Governorates
        'NABLUS_GOV': 'Nablus',
        'RAMALLAH_BIREH_GOV': 'Ramallah and Al-Bireh',
        'HEBRON_GOV': 'Hebron',
        'JERUSALEM_GOV': 'Jerusalem',
        'BETHLEHEM_GOV': 'Bethlehem',
        'JENIN_GOV': 'Jenin',
        'TULKARM_GOV': 'Tulkarm',
        'QALQILYA_GOV': 'Qalqilya',
        'SALFIT_GOV': 'Salfit',
        'JERICHO_GOV': 'Jericho and the Jordan Valley',
        'GAZA_GOV': 'Gaza',
        'NORTH_GAZA_GOV': 'North Gaza',
        'DEIR_BALAH_GOV': 'Deir al-Balah',
        'KHAN_YOUNIS_GOV': 'Khan Younis',
        'RAFAH_GOV': 'Rafah'
,
'FILTER_OPTIONS': 'Filter Options',
'SELECT_CITY': 'Select City',
'SELECT_REGION': 'Select Region',
'SELECT_GOVERNORATE': 'Select Governorate',
'CANCEL': 'Cancel',
'APPLY': 'Apply',
'CLEAR_FILTERS': 'Clear Filters',

  });

  // Arabic translations
  $translateProvider.translations('ar', {
    'USER_MANAGEMENT': 'إدارة المستخدمين',
    'ALL_USERS': 'جميع المستخدمين',
    'SEARCH_PLACEHOLDER': 'بحث ...',
    'FILTERS': 'الفلاتر',
    'ADD_USER': 'إضافة مستخدم',
    'NAME': 'الاسم',
        'PHONE':'رقم الهاتف',

    // Add User Form
'ADD_USER_FORM': 'إضافة مستخدم',
'FULL_ENG_NAME': 'الاسم الكامل بالإنجليزية',
'FULL_ARAB_NAME': 'الاسم الكامل بالعربية',
'DOB': 'تاريخ الميلاد',
'SUBMIT': 'إضافة مستخدم',
'CANCEL': 'إلغاء',
'ENG_NAME_PLACEHOLDER': 'Enter your full name in English',
'ARAB_NAME_PLACEHOLDER': 'أدخل اسمك الكامل بالعربية',
    'FULL ENG NAME':'Full Name',
    'ID_NUMBER': 'رقم الهوية',
    'REGION': 'المنطقة',
    'CITY': 'المدينة',
    'GOVERNORATE': 'المحافظة',
    'ACTIONS': 'الإجراءات',
    'ADD': 'إضافة',
    'SHOW_MINORS': 'عرض الاطفال',
    'DELETE': 'حذف',
    

'EDITE':'تعديل',
'FILTER_OPTIONS': 'خيارات الفلترة',
'SELECT_CITY': 'اختر المدينة',
'SELECT_REGION': 'اختر المنطقة',
'SELECT_GOVERNORATE': 'اختر المحافظة',
'CANCEL': 'إلغاء',
'APPLY': 'تطبيق',
'CLEAR_FILTERS': 'مسح الفلاتر',
     // Regions
        'WEST_BANK': 'الضفة الغربية',
        'GAZA_STRIP': 'قطاع غزة',
        // Cities
        'NABLUS': 'نابلس',
        'RAMALLAH': 'رام الله',
        'HEBRON': 'الخليل',
        'JERUSALEM': 'القدس',
        'BETHLEHEM': 'بيت لحم',
        'JENIN': 'جنين',
        'TULKARM': 'طولكرم',
        'QALQILYA': 'قلقيلية',
        'SALFIT': 'سلفيت',
        'JERICHO': 'أريحا',
        'GAZA': 'غزة',
        'KHAN_YOUNIS': 'خان يونس',
        'RAFAH': 'رفح',
        // Governorates
        'NABLUS_GOV': 'نابلس',
        'RAMALLAH_BIREH_GOV': 'رام الله والبيرة',
        'HEBRON_GOV': 'الخليل',
        'JERUSALEM_GOV': 'القدس',
        'BETHLEHEM_GOV': 'بيت لحم',
        'JENIN_GOV': 'جنين',
        'TULKARM_GOV': 'طولكرم',
        'QALQILYA_GOV': 'قلقيلية',
        'SALFIT_GOV': 'سلفيت',
        'JERICHO_GOV': 'أريحا والأغوار',
        'GAZA_GOV': 'غزة',
        'NORTH_GAZA_GOV': 'شمال غزة',
        'DEIR_BALAH_GOV': 'دير البلح',
        'KHAN_YOUNIS_GOV': 'خان يونس',
        'RAFAH_GOV': 'رفح'
  });

 // Set default language
  $translateProvider.preferredLanguage('en');
  $translateProvider.fallbackLanguage('en');
});



mypage.controller('mainpageCTRL', function ($scope ,$translate) {

    // ADD THESE NEW LANGUAGE MANAGEMENT VARIABLES
  $scope.selectedLanguage = 'en';
  $scope.currentDirection = 'ltr';

  // ADD THIS NEW FUNCTION
  $scope.changeLanguage = function() {
    $translate.use($scope.selectedLanguage);
    
    // Set text direction based on language
    if ($scope.selectedLanguage === 'ar') {
      $scope.currentDirection = 'rtl';
      document.documentElement.setAttribute('lang', 'ar');
    } else {
      $scope.currentDirection = 'ltr';
      document.documentElement.setAttribute('lang', 'en');
    }
  };

    $scope.dropdownContent = ['EDITE', 'SHOW_MINORS', 'DELETE'];
    $scope.showDropdown = false;
    $scope.toggleDropdown = function () {
        console.log('toggleDropdown called, current value:', $scope.showDropdown);

        $scope.showDropdown = !$scope.showDropdown;
        console.log('toggleDropdown new value:', $scope.showDropdown);
    };


     $scope.currentPage = 1;
     $scope.numPerPage = 5;
     $scope.filtered = $scope.roles || [];
     $scope.totalItems = $scope.filtered.length;
     $scope.searchText = '';
     
        $scope.paginate = function (value) {
            var begin, end, index;
            begin = ($scope.currentPage - 1) * $scope.numPerPage;
            end = begin + $scope.numPerPage;
            index = $scope.roles.indexOf(value);
            return (begin <= index && index < end);
        };
        $scope.getFilteredRoles = function () {
            if (!$scope.roles) return [];
            var search = $scope.searchText ? $scope.searchText.toLowerCase() : '';
            return $scope.roles.filter(function (role) {
                return !search ||
                    (role.name && role.name.toLowerCase().includes(search)) ||
                    (role.ID_NUMBER && role.ID_NUMBER.toLowerCase().includes(search));
            });
        };


        $scope.paginatedRoles = function () {
            var filtered = $scope.getFilteredRoles();
            // Update total items for pagination
            $scope.totalItems = filtered.length;
            var begin = ($scope.currentPage - 1) * $scope.numPerPage;
            var end = begin + $scope.numPerPage;
            return filtered.slice(begin, end);
        };

        $scope.$watchGroup(['currentPage', 'numPerPage'], function (newValues, oldValues) {
            console.log('Pagination updated:', {
                page: newValues[0],
                perPage: newValues[1],
                total: $scope.totalItems
            });
        });



        $scope.showFilterPopup=false;
         $scope.filters = {
    selectedCity: '',
    selectedRegion: '',
    selectedGovernorate: ''
  };
 $scope.openFilterPopup = function() {
    $scope.showFilterPopup = true;
    console.log('Applying filters:',  $scope.showFilterPopup);
  };

  $scope.closeFilterPopup = function() {
    $scope.showFilterPopup = false;
  };

  $scope.applyFilters = function() {
    // Apply your filtering logic here
    console.log('Applying filters:', $scope.filters);
    $scope.showFilterPopup = false;
  };

  // Individual filter functions
  $scope.FilterByCity = function() {
    console.log('Filter by city:', $scope.filters.selectedCity);
  };

  $scope.FilterByRegion = function() {
    console.log('Filter by region:', $scope.filters.selectedRegion);
  };

  $scope.FilterByGovernorate = function() {
    console.log('Filter by governorate:', $scope.filters.selectedGovernorate);
  };


     $scope.showAddForm=false;

     $scope.openAddForm = function() {
    $scope.showAddForm = true;
    console.log('Add Form Open:',  $scope.showAddForm);
  };


 $scope.closeAddForm = function() {
    $scope.showAddForm = false;
  };

  $scope.showEditForm=false;




  $scope.openEditForm = function() {
    $scope.showEditForm = true;
    console.log('Edit Form Open:',  $scope.showEditForm);
  };

 $scope.closeEditForm = function() {
    $scope.showEditForm = false;
  };

$scope.showDeleteForm=false;

 $scope.openDeleteForm = function() {
    $scope.showDeleteForm = true;
    console.log('Delete Form Open:',  $scope.showDeleteForm);
  };

 $scope.closeDeleteForm = function() {
    $scope.showDeleteForm = false;
  };
});
