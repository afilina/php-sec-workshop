<?php

namespace App\Controller;

use App\Interfaces\ReflectionInterface;
use App\Repository\RainbowRepository;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class PasswordController extends Controller
{
    /**
     * @Route("/rainbow-table", name="rainbow_table")
     */
    public function rainbowTable(Request $request, RainbowRepository $rainbowRepo, ReflectionInterface $reflection)
    {
        $values = [
            '202cb962ac59075b964b07152d234b70',
            '900150983cd24fb0d6963f7d28e17f72',
            'aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa',
        ];
        $form = $this->createFormBuilder(null)
            ->add('hashes', TextareaType::class, [
                'data' => implode("\r\n", $values),
                'attr' => ['style' => 'height:90px'],
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'Search'
            ])
            ->getForm();

        $form->handleRequest($request);

        $passwordResults = [];
        if ($form->isSubmitted() && $form->isValid()) {
            $input = $form->getData();
            $hashes = explode("\r\n", $input['hashes']);
            $passwordResults = $rainbowRepo->findBy(['hash' => $hashes]);
        }

        return $this->render('password/rainbow.html.twig', [
            'form' => $form->createView(),
            'passwordResults' => $passwordResults,
            'code' => $reflection->getMethodLines($this, 'rainbowTable', 21, 2, true),
        ]);
    }

    /**
     * @Route("/benchmark", name="benchmark")
     */
    public function benchmark(ReflectionInterface $reflection)
    {
        $numPasswords = 100000;
        $plaintext = '123';

        $time = microtime(true);
        for ($i=0; $i<$numPasswords; $i++) {
            md5($plaintext);
        }
        $time = microtime(true) - $time;

        $code = $reflection->getMethodLines($this, 'benchmark', 6, 1, true);

        return $this->render('password/benchmark.html.twig', [
            'algo' => 'MD5',
            'plaintextLength' => strlen($plaintext),
            'numPasses' => 1,
            'numPasswords' => number_format($numPasswords),
            'time' => round($time,6),
            'code' => $code,
        ]);
    }

    /**
     * @Route("/benchmark-salted", name="benchmark_salted")
     */
    public function saltedBenchmark(ReflectionInterface $reflection)
    {
        $numPasswords = 100000;
        $plaintext = '123';

        $time = microtime(true);
        for ($i=0; $i<$numPasswords; $i++) {
            $bytes = random_bytes(16);
            $salt = substr(bin2hex($bytes), 0, 32);
            md5($plaintext.$salt);
        }
        $time = microtime(true) - $time;

        $code = $reflection->getMethodLines($this, 'saltedBenchmark', 6, 3, true);

        return $this->render('password/benchmark.html.twig', [
            'algo' => 'MD5 + salt',
            'plaintextLength' => strlen($plaintext)+32,
            'numPasses' => 1,
            'numPasswords' => number_format($numPasswords),
            'time' => round($time,6),
            'code' => $code,
        ]);
    }

    /**
     * @Route("/benchmark-repeated/{cost}", name="benchmark_repeated")
     */
    public function repeatedBenchmark(ReflectionInterface $reflection, int $cost = 10)
    {
        $numPasswords = 1;
        $plaintext = '123';

        $time = microtime(true);
        for ($i=0; $i<$numPasswords; $i++) {
            //...
        }
        $time = microtime(true) - $time;

        $code = $reflection->getMethodLines($this, 'repeatedBenchmark', 6, 1, true);

        return $this->render('password/benchmark.html.twig', [
            'algo' => "Bcrypt + cost({$cost})",
            'plaintextLength' => strlen($plaintext),
            'numPasses' => 1,
            'numPasswords' => number_format($numPasswords),
            'time' => round($time,6),
            'code' => $code,
        ]);
    }
}
