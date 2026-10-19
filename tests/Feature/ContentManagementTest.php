<?php

namespace Tests\Feature;

use App\Models\AboutModel;
use App\Models\BlogModel;
use App\Models\HomeModel;
use App\Models\PortofolioModel;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class ContentManagementTest extends TestCase
{
    use RefreshDatabase;

    public function test_home_content_can_be_created_updated_and_deleted_with_its_image(): void
    {
        Storage::fake('public');

        $this->post(route('manage.home.store'), [
            'content' => 'Sambutan baru',
            'foto' => UploadedFile::fake()->create('profile.jpg', 100, 'image/jpeg'),
        ])->assertRedirect(route('manage'));

        $home = HomeModel::firstOrFail();
        $oldPath = str_replace('/storage/', '', $home->foto);
        Storage::disk('public')->assertExists($oldPath);

        $this->put(route('manage.home.update', $home), [
            'content' => 'Sambutan diperbarui',
            'foto' => UploadedFile::fake()->create('profile-baru.jpg', 100, 'image/jpeg'),
        ])->assertRedirect(route('manage'));

        $home->refresh();
        $newPath = str_replace('/storage/', '', $home->foto);
        $this->assertSame('Sambutan diperbarui', $home->content);
        Storage::disk('public')->assertMissing($oldPath);
        Storage::disk('public')->assertExists($newPath);

        $this->delete(route('manage.home.destroy', $home))->assertRedirect(route('manage'));

        $this->assertDatabaseMissing('home', ['id' => $home->id]);
        Storage::disk('public')->assertMissing($newPath);
    }

    public function test_about_content_can_be_created_updated_and_deleted(): void
    {
        $this->post(route('manage.about.store'), [
            'aboutme' => 'Tentang saya',
            'study' => 'Pendidikan saya',
            'skill' => 'Kemampuan saya',
        ])->assertRedirect(route('manage'));

        $about = AboutModel::firstOrFail();
        $this->put(route('manage.about.update', $about), [
            'aboutme' => 'Profil diperbarui',
            'study' => 'Pendidikan diperbarui',
            'skill' => 'Kemampuan diperbarui',
        ])->assertRedirect(route('manage'));

        $this->assertDatabaseHas('about', [
            'id' => $about->id,
            'aboutme' => 'Profil diperbarui',
        ]);
        $this->get(route('about'))->assertOk()->assertSee('Profil diperbarui');

        $this->delete(route('manage.about.destroy', $about))->assertRedirect(route('manage'));
        $this->assertDatabaseMissing('about', ['id' => $about->id]);
    }

    public function test_portfolio_content_can_be_created_updated_and_deleted_with_its_image(): void
    {
        Storage::fake('public');

        $this->post(route('manage.portfolio.store'), [
            'foto' => UploadedFile::fake()->create('project.jpg', 100, 'image/jpeg'),
            'judul' => 'Proyek pertama',
            'isi' => 'Deskripsi proyek',
            'link' => 'https://example.com/project',
        ])->assertRedirect(route('manage'));

        $portfolio = PortofolioModel::firstOrFail();
        $oldPath = str_replace('/storage/', '', $portfolio->foto);
        Storage::disk('public')->assertExists($oldPath);

        $this->put(route('manage.portfolio.update', $portfolio), [
            'judul' => 'Proyek diperbarui',
            'isi' => 'Deskripsi diperbarui',
            'link' => 'https://example.com/project-updated',
        ])->assertRedirect(route('manage'));

        $this->assertDatabaseHas('port', [
            'id' => $portfolio->id,
            'judul' => 'Proyek diperbarui',
            'foto' => $portfolio->fresh()->foto,
        ]);
        Storage::disk('public')->assertExists($oldPath);

        $this->delete(route('manage.portfolio.destroy', $portfolio))->assertRedirect(route('manage'));
        $this->assertDatabaseMissing('port', ['id' => $portfolio->id]);
        Storage::disk('public')->assertMissing($oldPath);
    }

    public function test_blog_content_can_be_created_updated_and_deleted(): void
    {
        $this->post(route('manage.blog.store'), [
            'title' => 'Artikel pertama',
            'subtitle' => 'Subjudul pertama',
            'description' => 'Isi artikel pertama',
        ])->assertRedirect(route('manage'));

        $blog = BlogModel::firstOrFail();
        $this->put(route('manage.blog.update', $blog), [
            'title' => 'Artikel diperbarui',
            'subtitle' => 'Subjudul diperbarui',
            'description' => 'Isi diperbarui',
        ])->assertRedirect(route('manage'));

        $this->assertDatabaseHas('blog', [
            'id' => $blog->id,
            'title' => 'Artikel diperbarui',
        ]);

        $this->delete(route('manage.blog.destroy', $blog))->assertRedirect(route('manage'));
        $this->assertDatabaseMissing('blog', ['id' => $blog->id]);
    }

    public function test_management_page_lists_all_content_sections(): void
    {
        $this->get(route('manage'))
            ->assertOk()
            ->assertSee('Home')
            ->assertSee('About')
            ->assertSee('Portfolio')
            ->assertSee('Blog');

        $this->get(route('portofolio.add'))
            ->assertRedirect(route('manage').'#portfolio');
    }

    public function test_management_page_shows_each_entity_as_a_table_with_edit_forms(): void
    {
        $home = HomeModel::create(['content' => 'Sambutan tabel', 'foto' => '/images/profile.jpg']);
        $about = AboutModel::create([
            'aboutme' => 'Profil tabel',
            'study' => 'Pendidikan tabel',
            'skill' => 'Kemampuan tabel',
        ]);
        $portfolio = PortofolioModel::create([
            'foto' => '/images/project.jpg',
            'judul' => 'Proyek tabel',
            'isi' => 'Deskripsi tabel',
            'link' => 'https://example.com/project',
        ]);
        $blog = BlogModel::create([
            'title' => 'Artikel tabel',
            'subtitle' => 'Subjudul tabel',
            'description' => 'Isi artikel tabel',
        ]);

        $this->get(route('manage'))
            ->assertOk()
            ->assertSee('Sambutan tabel')
            ->assertSee('Profil tabel')
            ->assertSee('Proyek tabel')
            ->assertSee('Artikel tabel')
            ->assertSee(route('manage.home.update', $home), false)
            ->assertSee(route('manage.about.update', $about), false)
            ->assertSee(route('manage.portfolio.update', $portfolio), false)
            ->assertSee(route('manage.blog.update', $blog), false);
    }

    public function test_public_pages_render_the_database_content(): void
    {
        HomeModel::create(['content' => 'Teks Home dari database', 'foto' => '/images/profile.jpg']);
        AboutModel::create([
            'aboutme' => 'Profil dari database',
            'study' => 'Pendidikan dari database',
            'skill' => 'Kemampuan dari database',
        ]);
        PortofolioModel::create([
            'foto' => '/images/project.jpg',
            'judul' => 'Proyek dari database',
            'isi' => 'Deskripsi proyek dari database',
            'link' => 'https://example.com/project',
        ]);
        BlogModel::create([
            'title' => 'Artikel dari database',
            'subtitle' => 'Subjudul dari database',
            'description' => 'Isi artikel dari database',
        ]);

        $this->get(route('home'))->assertOk()->assertSee('Teks Home dari database');
        $this->get(route('about'))->assertOk()->assertSee('Profil dari database')->assertSee('Pendidikan dari database');
        $this->get(route('portofolio'))->assertOk()->assertSee('Proyek dari database');
        $this->get(route('blog'))->assertOk()->assertSee('Artikel dari database')->assertSee('Isi artikel dari database');
    }
}
