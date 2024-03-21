<?php

class LoginInfoView extends ProfileInfo {
    
    public function fetchTitle($userId) {
        $profileInfo = $this->getProfileInfo($userId);

        echo $profileInfo[0]["profiles_introtitle"];
}

    public function fetchAbout($userId) {
        $profileInfo = $this->getProfileInfo($userId);

        echo $profileInfo[0]["profiles_about"];
}
        public function fetchText($userId) {
        $profileInfo = $this->getProfileInfo($userId);

        echo $profileInfo[0]["profiles_introtext"];
}

}