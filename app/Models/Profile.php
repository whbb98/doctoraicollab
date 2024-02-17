<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Http\Request;

class Profile extends Model
{
    use HasFactory;

    protected $table = 'profile';
    protected $primaryKey = 'id';
    public $incrementing = true;
    public $timestamps = false;

    protected $attributes = [
        'bio' => 'Welcome to my profile!',
        'city' => '31',
        'hospital' => 'your hospital',
        'occupation' => 'your occupation',
        'department' => 'your department'
    ];

    protected $fillable = [
        'photo',
        'cover',
        'bio',
        'city',
        'hospital',
        'occupation',
        'department'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }


    public function updatePhoto($file)
    {
        $this->photo = file_get_contents($file->getPathname());
        return $this->save();
    }

    public function updateCover($file)
    {
        $this->cover = file_get_contents($file->getPathname());
        return $this->save();
    }

    public function updateBio($bio) // updateProfilePersonalInfo
    {

        $this->bio = trim($bio);
        return $this->save();
    }

    public function updateCareer(Request $req)
    {
        $this->occupation = strip_tags($req->occupation);
        $this->department = strip_tags($req->department);
        $this->hospital = strip_tags($req->hospital);
        $this->other_hospital = strip_tags($req->other_hospital);
        $this->city = strip_tags($req->city);
        return $this->save();
    }

    public function getPhoto()
    {
        if ($this->photo == null) {
            return null;
        } else {
            $finfo = finfo_open(FILEINFO_MIME_TYPE);
            $mimeType = finfo_buffer($finfo, $this->photo);
            finfo_close($finfo);
            return "data:$mimeType;base64," . base64_encode($this->photo);
        }
    }

    public function getCover()
    {
        if ($this->cover == null) {
            return null;
        } else {
            $finfo = finfo_open(FILEINFO_MIME_TYPE);
            $mimeType = finfo_buffer($finfo, $this->cover);
            finfo_close($finfo);
            return "data:$mimeType;base64," . base64_encode($this->cover);
        }
    }

    public function deletePhoto()
    {
        $this->photo = null;
        return $this->save();
    }

    public function deleteCover()
    {
        $this->cover = null;
        return $this->save();
    }

    public function getCityName()
    {
        global $cities;
        return $cities[$this->city];
    }

    public function getDpartmentName()
    {
        global $hospitalDepartments;
        return $hospitalDepartments[$this->department];
    }

    public function getHospitalName()
    {
        global $hospitals;
        if ($this->hospital === "0") {
            return $this->other_hospital;
        } else {
            return $hospitals[$this->hospital];
        }
    }
}
