<?php

namespace App\Policies;

use App\Models\Job;
use App\Models\User;

class JobPolicy
{
    public function viewAny(User $user): bool
    {
        return true; // همه کاربران لاگین شده می‌توانند لیست شغل‌ها را ببینند
    }

    public function view(User $user, Job $job): bool
    {
        return true; // همه می‌توانند جزئیات یک شغل را باز کنند
    }

    public function create(User $user): bool
    {
        // فقط کاربرانی که نقش کارفرما (employer) دارند اجازه دارند شغل جدید ثبت کنند
        return $user->role === 'employer';
    }

    public function update(User $user, Job $job): bool
    {
        // کارفرما فقط زمانی اجازه ویرایش دارد که این شغل متعلق به پروفایل خودش باشد
        return $user->employer && $user->employer->employer_id === $job->employer_id;
    }

    public function delete(User $user, Job $job): bool
    {
        // کارفرما فقط زمانی اجازه حذف دارد که این شغل متعلق به پروفایل خودش باشد
        return $user->employer && $user->employer->employer_id === $job->employer_id;
    }
}
