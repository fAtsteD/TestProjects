<?php

/**
 * Generate projects, bugs, users
 */
final class TestProjectsGenerate
{
    private $number;

    const ROOT_PROJECTS = [
        'Test1',
        'Test2',
        'Test3',
        'Test4',
        'Root',
    ];

    const NUMBER_MIDDLE = 200;
    const NUMBER_BUGS = 40;

    public function __construct(int $number = 1)
    {
        $this->number = $number;
    }

    /**
     * Generate
     */
    public function generate()
    {
        config_set('allow_no_category', ON);
        $this->root_projects();
        $t_root_project_id = project_get_id_by_name('Root');

        for ($i = 0; $i < $this->number; $i++) {
            $t_middle_project_id = $this->project($this->generate_word(8), $t_root_project_id);

            for ($j = 0; $j < self::NUMBER_MIDDLE; $j++) {
                $t_name = '';

                do {
                    $t_name = $this->generate_word(15);
                } while (project_get_id_by_name($t_name));

                $t_project_id = $this->project($t_name, $t_middle_project_id);
                $t_user_id = $this->user($t_name, $t_project_id);

                for ($k = 0; $k < self::NUMBER_BUGS; $k++) {
                    $this->bug($t_user_id, $t_project_id);
                }
            }
        }
    }

    private function root_projects()
    {
        foreach (self::ROOT_PROJECTS as $t_project_name) {
            $t_exist_project = project_get_id_by_name($t_project_name);

            if (!$t_exist_project) {
                $t_data = array(
                    'payload' => array(
                        'name' => $t_project_name,
                        'view_state' => array('id' => VS_PRIVATE),
                        'status' => array('id' => 10)
                    ),
                );

                $t_command = new ProjectAddCommand($t_data);
                $t_command->execute();
            }
        }
    }

    private function project($p_name, $p_parent_id): int
    {
        $t_data = array(
            'payload' => array(
                'name' => $p_name,
                'view_state' => array('id' => VS_PRIVATE),
                'status' => array('id' => 10)
            ),
            'options' => array(
                'return_project' => false
            )
        );

        $t_command = new ProjectAddCommand($t_data);
        $t_result = $t_command->execute();
        $t_project_id = $t_result['id'];

        $t_data = array(
            'query' => array(
                'project_id' => (int)$p_parent_id
            ),
            'payload' => array(
                'project' => array(
                    'id' => (int)$t_project_id
                ),
                'inherit_parent' => true,
            )
        );

        $t_command = new ProjectHierarchyAddCommand($t_data);
        $t_result = $t_command->execute();

        return $t_project_id;
    }

    private function user($p_name, $p_project_id = 0): int
    {
        $t_data = array(
            'query' => array(),
            'payload' => array(
                'username' => $p_name,
                'email' => "$p_name@example.com",
                'access_level' => array('id' => VIEWER),
                'real_name' => $p_name,
                'password' => '123456',
                'enabled' => true
            )
        );

        $t_command = new UserCreateCommand($t_data);
        $t_result = $t_command->execute();
        $t_user_id = $t_result['id'];

        $t_data = array(
            'payload' => array(
                'project' => array(
                    'id' => $p_project_id
                ),
                'user' => array(
                    'id' => $t_user_id
                ),
                'access_level' => array(
                    'id' => DEVELOPER
                )
            )
        );

        $t_command = new ProjectUsersAddCommand($t_data);
        $t_command->execute();

        return $t_user_id;
    }

    private function bug($p_user_id, $p_project_id): int
    {
        $t_data = array(
            'payload' => array(
                'issue' => array(
                    'project' => array('id' => $p_project_id),
                    'reporter' => array('id' => $p_user_id),
                    'summary' => $this->generate_sentence(3),
                    'description' => $this->generate_sentence(),
                    'handler' => array('id' => auth_get_current_user_id()),
                    'status' => array('id' => ASSIGNED),
                )
            ),
        );

        $t_command = new IssueAddCommand($t_data);
        $t_result = $t_command->execute();
        $t_issue_id = (int)$t_result['issue_id'];

        return $t_issue_id;
    }

    private function generate_sentence($p_max_words = 10): string
    {
        $t_number_words = rand(1, $p_max_words);
        $t_result = '';

        for ($i = 0; $i < $t_number_words; $i++) {
            $t_result .= $this->generate_word(rand(1, 10));

            if ($i != $t_number_words - 1) {
                $t_result .= ' ';
            } else {
                $t_result .= '.';
            }
        }

        return $t_result;
    }

    private function generate_word($p_length = 10): string
    {
        $t_characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $t_random_string = substr(str_shuffle($t_characters), 0, $p_length);

        return $t_random_string;
    }
}
