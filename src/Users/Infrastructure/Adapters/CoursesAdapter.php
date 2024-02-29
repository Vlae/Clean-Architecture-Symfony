<?php

namespace App\Users\Infrastructure\Adapters;

use App\Courses\Infrastructure\API\API;

class CoursesAdapter
{
    /**
     * @param API $coursesApi
     */
    public function __construct(private readonly API $coursesApi)
    {
    }

    /**
     * @return array
     */
    public function getCoursesForUser(): array
    {
        $userCourses = $this->coursesApi->getCoursesForUser();
        // mapping
        $mappedCourses['1'] = $userCourses;

        return $mappedCourses;
    }
}